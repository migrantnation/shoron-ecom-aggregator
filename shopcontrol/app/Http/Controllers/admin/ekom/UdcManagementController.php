<?php

namespace App\Http\Controllers\admin\ekom;

use App\Libraries\ChangeOrderStatus;
use App\models\CountryLocation;
use App\models\LogisticPartner;
use App\models\Order;
use App\models\UdcCustomer;
use App\models\UdcPayment;
use App\models\User;
use Carbon\Carbon;
use DB;
use App\models\Location;
use App\models\Udc;
//use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Validator;
use App\Http\Controllers\Controller;
use App\models\OrderTrack;

use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Illuminate\Support\Facades\File;

class UdcManagementController extends Controller
{
    public $row_per_page = 10;


    public function index(Request $request)
    {
        $data = array();
        $data['status'] = 100;
        $response = array();
        $response['message'] = 'There is a problem with status changing';

        $data['all_lp'] = LogisticPartner::where('status', 1)->get();

        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['udc_management'] = 'start active open';
        $data['all_udc'] = 'active';
        $input = $request->all();

        $data['division'] = User::where('user_type', 1)->select('division')->groupBy('division')->get();
        $data['district'] = User::where('user_type', 1)->where('division', @$input['division'])->select('district')->groupBy('district')->get();
        $data['upazila'] = User::where('user_type', 1)->where('district', @$input['district'])->select('upazila')->groupBy('upazila')->get();
        $data['union'] = User::where('user_type', 1)->where('upazila', @$input['upazila'])->select('union')->groupBy('union')->get();

        $data['limit'] = $limit = $request->limit ? $request->limit : 15;
        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $limit) + 1 : 1;

        if (@$request->status != '' && @$request->user_id) {
            $get_user = User::where('id', $request->user_id)->first();
            $get_user->status = $request->status;
            if ($get_user->save())
                $data['status'] = 200;
            $data['message'] = 'Status has been changed successfully';
        }

        $raw_sql = '';
        if (isset($input['division']))
            $raw_sql .= " (`division` LIKE '%" . $input['division'] . "%')";

        if (isset($input['district']))
            $raw_sql .= " and (`district` LIKE '%" . $input['district'] . "%')";

        if (isset($input['upazila']))
            $raw_sql .= " and (`upazila` LIKE '%" . $input['upazila'] . "%')";

        if (isset($input['union']))
            $raw_sql .= " and (`union` LIKE '%" . $input['union'] . "%')";

        $raw_sql = $raw_sql ? $raw_sql : 'id IS NOT NULL';

        $user_list_q = User::where('user_type', 1)->where(function ($query) use ($request) {
            if ($request->tab_id != '') {
                if ($request->tab_id != 'all') {
                    if ($request->tab_id == 4) { // USER OUT OF REACH
                        $query->whereDoesntHave('udc_package', function ($nested_query) use ($request) {
                            $nested_query->where('is_selected', 1);
                        });
                    } else if ($request->tab_id == 'transacting') { // ACTIVE USERS
                        $query->where('status', 1);
                        $query->whereHas('orders', function ($q) use ($request) {
                            if (@$request->from) {
                                $q->where('created_at', '>=', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
                            }
                            if (@$request->to) {
                                $q->where('created_at', '<=', date('Y-m-d H:i:s', strtotime("$request->to 23:59:50")));
                            }
                        });
                    } else if ($request->tab_id == '0' ) {  // USERS NEED ACTIVATION
                        $query->whereHas('udc_package', function ($q) {
                            $q->where('is_selected', 1);
                        })->where('status', '=', 0)
						//->orWhere('status', '=', 2)
						;

                    } else if ($request->tab_id == 1) {  // ACTIVATED USERS
                        $query->where('status', 1);
                        $query->whereHas('udc_package');
                    } else if ($request->tab_id == 'non-transacting') {
                        $query->whereHas('udc_package');
                        $query->where('status', 1);
                        $query->doesntHave('orders');
                    }else {  // USERS NEED ACTIVATION
                        //$query->where('status', '!=', 1);
                    }
                }
            }
        })->orderBy('id', 'desc')->with(['udc_package', 'orders' => function ($q) use ($request) {
            if (@$request->from) {
                $q->where('created_at', '>=', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
            }
            if (@$request->to) {
                $q->where('created_at', '<=', date('Y-m-d H:i:s', strtotime("$request->to 23:59:50")));
            }
        }])->whereRaw("$raw_sql");

        if (!empty($input['search_string']) || !empty($raw_sql) || $request->tab_id != '') {
            $skey = @$input['search_string'];
            $user_list_q = $user_list_q->where(function ($query) use ($request, $skey) {
                $query->where('center_name', "LIKE", '%' . $skey . '%')
                    ->orwhere('name_bn', 'LIKE', '%' . $skey . '%')
                    ->orwhere('name_en', 'LIKE', '%' . $skey . '%')
                    ->orwhere('division', 'LIKE', '%' . $skey . '%')
                    ->orwhere('district', 'LIKE', '%' . $skey . '%')
                    ->orwhere('union', 'LIKE', '%' . $skey . '%')
                    ->orwhere('upazila', 'LIKE', '%' . $skey . '%')
                    ->orwhere('address', 'LIKE', '%' . $skey . '%')
                    ->orwhere('national_id_no', 'LIKE', '%' . $skey . '%')
                    ->orwhere('email', 'LIKE', '%' . $skey . '%')
                    ->orwhere('phone', 'LIKE', '%' . $skey . '%')
                    ->orwhere('center_id', 'LIKE', '%' . $skey . '%')
                    ->orwhere('entrepreneur_id', 'LIKE', '%' . $skey . '%')
                    ->orwhere('bkash_number', 'LIKE', '%' . $skey . '%')
                    ->orwhere('rocket_number', 'LIKE', '%' . $skey . '%')
                    ->orwhere('contact_number', 'LIKE', '%' . $skey . '%');
            });

            $pagination_path = "?search_string=" . $skey
                . "&division=" . $request->division
                . "&district=" . $request->district
                . "&upazila=" . $request->upazila
                . "&union=" . $request->union
                . "&from=" . $request->from
                . "&to=" . $request->to
                . "&tab_id=" . $request->tab_id;

            if (@$request->export_type) {
                $data['udc_list'] = $user_list_q->get();
            } else if (@$request->limit == 'all') {
                $data['udc_list'] = $user_list_q->get();
            } else {
                $data['udc_list'] = $user_list_q->paginate($limit)->withPath($pagination_path);
            }

        } else {
            if (@$request->export_type) {
                $data['udc_list'] = $user_list_q->get();
            } else if (@$request->limit == 'all') {
                $data['udc_list'] = $user_list_q->get();
            } else {
                $data['udc_list'] = $user_list_q->paginate($limit);
            }
        }


        //START EXPORT IN CSV or EXCEL
        if (@$request->export_type == 'csv') {
            $writer = WriterFactory::create(Type::CSV);
            $file_name = "udc_list-" . date("YmdHis") . ".csv";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->createExportFile($writer, $data['udc_list'], $filePath);
            return Response::download($filePath, $file_name);
        } else if ($request->export_type == 'xlsx') {
            $writer = WriterFactory::create(Type::XLSX);
            $file_name = "udc_list-" . date("YmdHis") . ".xlsx";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->createExportFile($writer, $data['udc_list'], $filePath);
            return Response::download($filePath, $file_name);
        }
        //END EXPORT IN CSV or EXCEL

        //RENDER VIEW
        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.udc.render_udc_list', $data)->render());
        } else {
            return view('admin.ekom.udc.udc_list')->with($data);
        }
    }

    public function createExportFile($writer, $all_udc, $filePath)
    {
        $writer->openToFile($filePath);
        $header_row = [
            "Slno",
            "Center ID",
            "Digital Center Name",
            "Entrepreneur Name",
            "Entrepreneur Contact Number",
            "Email",
            "Division",
            "District",
            "Upazila",
            "Union",
            "Address",
            "Enrolled Date",

            "Active Orders",
            "Warehouse Left Orders",
            "On Delivery Orders",
            "Delivered Orders",
            "Canceled Orders",
            "Total Orders",

            "Total Package Distributed"
        ];
        $writer->addRow($header_row);

        $i = 1;
        foreach ($all_udc as $key => $udc) {
            $lp_names = array();

            if (!empty(@$udc->udc_package_list)) {
                foreach ($udc->udc_package_list as $package)
                    $lp_names[] = @$package->logistic_partner->lp_name;
            }

            $index_datas = array(
                $i,
                @$udc->center_id,
                @$udc->center_name,
                @$udc->name_bn,
                @$udc->contact_number,
                @$udc->email,
                @$udc->division,
                @$udc->district,
                @$udc->upazila,
                @$udc->union,
                @$udc->address,
                date("Y-m-d H:i:s", strtotime(@$udc->created_at)),

                @$udc->orders->where('status', 1)->count(),
                @$udc->orders->where('status', 2)->count(),
                @$udc->orders->where('status', 3)->count(),
                @$udc->orders->where('status', 4)->count(),
                @$udc->orders->where('status', 5)->count(),
                @$udc->orders->count(),


                @$udc->udc_package_list->where('is_selected', 1)->count() . '(' . implode(', ', $lp_names) . ')',
            );

            $writer->addRow($index_datas);

            $i++;
        }
        $writer->close();
        return;
    }


    public function udc_profile($id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['udc_management'] = 'start active';

        $data['udc_id'] = $id;
        //$data['sub_menu'] = 'list';
        $data['udc_info'] = Udc::find($id);
        if ($data['udc_info']) {
            return view('admin.ekom.udc.udc_profile')->with($data);
        } else {
            return redirect('admin/udc');
        }
    }

    public function orders(Request $request, $id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['udc_management'] = 'start active open';
        $data['all_udc'] = 'active';

        $data['url'] = url("admin/udc/$id/orders");

        $data['udc_info'] = User::find($id);
        if (!$data['udc_info']) {
            return redirect('admin/udc');
        }

        $data['limit'] = $limit = $request->limit ? $request->limit : 15;
        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $limit) + 1 : 1;

        if ($request->search_string || $request->from || $request->to) {

            if ($request->from != '' && $request->to == '') {
                $request->to = Carbon::now();
            }

            $data['all_orders'] = Order::where('user_id', '=', $id)
                ->where(function ($query) use ($request) {

                    if ($request->tab_id >= 1) {
                        $query->where('status', $request->tab_id);
                    }

                    if (@$request->from != '') {
                        $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
                    }
                    if (@$request->to != '') {
                        $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime("$request->to 23:59:59")));
                    }

                })->where(function ($query) use ($request) {

                    $query->where('order_code', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('lp_name', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('ep_name', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('delivery_location', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('receiver_name', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('receiver_contact_number', 'LIKE', '%' . $request->search_string . '%');

                })->orderBy('id', 'desc');

        } else {

            if (isset($request->tab_id) && $request->tab_id != 'all') {
                $data['all_orders'] = Order::where('user_id', '=', $id)->where('status', '=', $request->tab_id)->orderBy('id', 'desc');
            } else {
                $data['all_orders'] = Order::where('user_id', '=', $id)->orderBy('id', 'desc');
            }

        }

        $data['total_price'] = $data['all_orders']->sum('total_price');
        $data['total_commission'] = $data['all_orders']->sum('udc_commission');
        $data['total_orders'] = $data['all_orders']->count();

        if (@$request->export_type || @$request->limit == 'all') {
            $data['all_orders'] = $data['all_orders']->get();
        } else {
            $data['all_orders'] = $data['all_orders']->paginate($limit)->withPath('?tab_id=' . $request->tab_id);
        }

        if (@$request->export_type == 'csv') {

            $writer = WriterFactory::create(Type::CSV);
            $file_name = "order_list-" . date("YmdHis") . ".csv";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->createOrdersExportFile($writer, $data['all_orders'], $filePath);
            return Response::download($filePath, $file_name);

        } else if (@$request->export_type == 'xlsx') {

            $writer = WriterFactory::create(Type::XLSX);
            $file_name = "order_list-" . date("YmdHis") . ".xlsx";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->createOrdersExportFile($writer, $data['all_orders'], $filePath);
            return Response::download($filePath, $file_name);

        }


        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.orders.render_ep_order_list', $data)->render());
        } else {
            return view('admin.ekom.orders.ep_order_list')->with($data);
        }
    }

    public function createOrdersExportFile($writer, $orders, $filePath)
    {
        $writer->openToFile($filePath);
        $header_row = ["Slno", "Order ID", "Order Date", "Delivery Duration", "EP Name", "LP Name",
            "Digital Center Name", "Center ID", "Entrepreneur Name", "Entrepreneur Contact Number", "District",
            "Union", "Total price", "Order Status",
        ];
        $writer->addRow($header_row);

        $order_status = array("", "Active", "Warehouse left", "In Transit", "Delivered", "Canceled");
        foreach ($orders as $key => $order) {
            $index_datas = array(
                $key + 1,
                @$order->order_code,
                date("Y-m-d H:i:s", strtotime(@$order->created_at)),
                @$order->delivery_duration,
                @$order->ep_name,
                @$order->lp_name,
                @$order->user->center_name,
                @$order->user->center_id,
                @$order->user->name_bn,
                @$order->user->contact_number,
                @$order->user->district,
                @$order->user->union,
                @$order->total_price,
                @$order_status[@$order->status],
            );
            $writer->addRow($index_datas);
        }

        $total_row = [
            "", "", "", "", "", "", "", "", "Total Orders ", "", $orders->count(),
            "Total Price ", $orders->sum('total_price'), "",
        ];
        $writer->addRow($total_row);

        $writer->close();
        return;
    }

    public function udc_purchased_products($id)
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['menu'] = 'management';
        //$data['sub_menu'] = 'list';
        $data['udc_list'] = Udc::find($id);

        $data['locations'] = CountryLocation::where('parent_id', 0)->get();

        return view('admin.ekom.udc.udc_purchased_products')->with($data);
    }

    public function edit_udc($id)
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['menu'] = 'management';
        //$data['sub_menu'] = 'list';
        $data['udc_list'] = Udc::find($id);
        return view('admin.ekom.udc.udc_profile')->with($data);
    }


    public function payments(Request $request, $user_id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['udc_management'] = 'start active open';
        $data['udc_payment'] = 'active';

        $data['udc_list'] = User::where('status', '=', 1)->get();

        $input = $request->all();

        return view('admin.not-found')->with($data);

//        if ($request->ajax()) {
//            return Response::json(View::make('admin.ekom.udc.render_udc_payments', $data)->render());
//        } else {
//            return view('admin.ekom.udc.udc_payments')->with($data);
//        }
    }

    public function all_udc_payments(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['udc_management'] = 'start active open';
        $data['udc_payment'] = 'active';

        $data['udc_list'] = User::where('status', '=', 1)->get();

        $input = $request->all();

        $data['udc_payments'] = Order::paginate($this->row_per_page);

        return view('admin.not-found')->with($data);

//        if ($request->ajax()) {
//            return Response::json(View::make('admin.ekom.udc.render_udc_payments', $data)->render());
//        } else {
//            return view('admin.ekom.udc.udc_payments')->with($data);
//        }
    }


    public function paymentDetails(Request $request, $udc_id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['udc_management'] = 'start active open';
        $data['udc_payment'] = 'active';
        $data['udc_payments'] = UdcPayment::where('udc_id', $udc_id)->paginate($this->row_per_page);
        $data['udc_info'] = User::where('id', $udc_id)->first();
        $data['total_paid'] = DB::table('udc_payments')
            ->selectRaw('sum(amount) as total_paid')
            ->where('udc_id', $udc_id)
//            ->groupBy('id')
            ->first();
        return view('admin.ekom.udc.udc_payment_details')->with($data);
    }


    public function reports(Request $request, $user_id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';

        $data['udc_management'] = 'start active open';
        $data['udc_report'] = 'active';

        $data['udc_list'] = User::where('status', '=', 1)->get();
        $data['udc_reports'] = Order::where('user_id', $user_id)->paginate($this->row_per_page);

        return view('admin.not-found')->with($data);

//        if ($request->ajax()) {
//            return Response::json(View::make('admin.ekom.udc.render_udc_reports', $data)->render());
//        } else {
//            return view('admin.ekom.udc.report.report')->with($data);
//        }
    }

    public function all_udc_reports(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['udc_management'] = 'start active open';
        $data['udc_report'] = 'active';

        $data['udc_list'] = User::where('status', '=', 1)->get();

        $input = $request->all();

        $data['udc_reports'] = Order::paginate($this->row_per_page);

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.udc.render_udc_reports', $data)->render());
        } else {
            return view('admin.ekom.udc.report.report')->with($data);
        }
    }


    public function transactions(Request $request, $user_id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';

        $data['udc_management'] = 'start active open';
        $data['udc_transaction'] = 'active';

        $data['udc_list'] = User::where('status', '=', 1)->get();

        $input = $request->all();

        $data['udc_reports'] = Order::where('user_id', $user_id)->paginate($this->row_per_page);

        return view('admin.not-found')->with($data);

//        if ($request->ajax()) {
//            return Response::json(View::make('admin.ekom.udc.transactions.render_index_data', $data)->render());
//        } else {
//            return view('admin.ekom.udc.transactions.index')->with($data);
//        }
    }

    public function all_udc_transactions(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['udc_management'] = 'start active open';
        $data['udc_transaction'] = 'active';

        $data['udc_list'] = User::where('status', '=', 1)->get();

        $input = $request->all();

        $data['udc_transactions'] = Order::orderBy('id', 'desc')->paginate($this->row_per_page);

        return view('admin.not-found')->with($data);

//        if ($request->ajax()) {
//            return Response::json(View::make('admin.ekom.udc.transactions.render_index_data', $data)->render());
//        } else {
//            return view('admin.ekom.udc.transactions.index')->with($data);
//        }
    }

    private function json($status = NULL, $response = NULL)
    {
        echo json_encode(array('meta' => array('status' => $status), 'response' => $response));
    }

    function dumpVar($data)
    {
        echo "<pre>";
        print_r($data);
        exit();
    }
}
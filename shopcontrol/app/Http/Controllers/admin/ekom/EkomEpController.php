<?php

namespace App\Http\Controllers\admin\ekom;

use App\CommissionDisbursementHistory;
use App\Libraries\ChangeOrderStatus;
use App\Libraries\EkomEncryption;
use App\Libraries\PlxUtilities;
use App\Libraries\Slim;
use App\models\EcommercePartner;
use App\models\Order;
use App\models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Validator;
use App\Http\Controllers\Controller;

use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Illuminate\Support\Facades\File;

class EkomEpController extends Controller
{
    public function __construct()
    {

    }

    public $row_per_page = 10;

    public function index()
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['ep_management'] = 'start active open';
        $data['all_ep'] = 'active';
        $data['ep_list'] = EcommercePartner::all();
        return view('admin.ekom.ep.index')->with($data);
    }

    public function add_ep()
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['ep_management'] = 'start active open';
        return view('admin.ekom.ep.edit-ep')->with($data);
    }

    public function store_ep(Request $request)
    {
        //(A – Z) (a – z)(0 – 9) Non-alphanumeric, Unicode characters
        $password_regex = "regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/";

        $validator = Validator::make($request->all(), [
            'ep_name' => 'required|unique:ecommerce_partners',
            'ep_short_code' => 'required|unique:ecommerce_partners|max:2|min:2',
            'email' => 'required|email|unique:ecommerce_partners',
            'password' => "required|min:6",
            'address' => 'required',
            'contact_person' => 'required|max:255',
            'contact_number' => 'required|max:15',
            'image' => 'required',

            'ep_url' => 'required|url|unique:ecommerce_partners',
            'product_search_url' => 'required|url|unique:ecommerce_partners',
            'auth_check_url' => 'required|url|unique:ecommerce_partners',
            'place_order_api_url' => 'required|url|unique:ecommerce_partners',

            'ep_commission' => '',
            'udc_commission' => '',
        ]);

        if ($validator->fails()) {
            return redirect("admin/add-ep")->withErrors($validator)->withInput();
        } else {

            //image upload
            $images = $request->file('image');
            if ($images) {
                $util = new PlxUtilities();
                $file_name = $util->create_clean_url($request->ep_name) . '-' . rand(1, 9) . date("s") . '-logo.png';
                $to = 'public/content-dir/ecommerce_partners/';
                $images->move($to, $file_name);
                $request->request->add(['ep_logo' => $file_name]);
            }
//            echo "<img src='$to$file_name' /> ";
//            dd($request);
            //end image upload

            $digits = 5;
            do {
                $ep_code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                $ep_code_exist = EcommercePartner::where('ep_code', $ep_code)->get();
            } while (!$ep_code_exist);

            $encryption = new EkomEncryption();
            $request->request->add([
                "access_token" => $encryption->encrypt(sha1($request->ep_url . md5($request->email))),
                "ep_code" => $ep_code,
                "password" => bcrypt($request->password),
            ]);

            EcommercePartner::create($request->all());
            return redirect("admin/all-ep");

        }
    }

    public function edit_ep(Request $request, $ep_id)
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['ep_management'] = 'start active open';
        $data['ep_info'] = EcommercePartner::find($ep_id);

        if (!$data['ep_info']) {
            return redirect('admin/all-ep');
        }

        return view('admin.ekom.ep.edit-ep')->with($data);
    }


    public function update_ep(Request $request)
    {
        if ($request->password != '') {
            $password_rule = "min:6";
            $request->request->add(["password" => bcrypt($request->password)]);
        } else {
            $password_rule = '';
        }

        $validator = Validator::make($request->all(), [
            'ep_name' => 'required|unique:ecommerce_partners,ep_name,' . $request->ep_id,
            'ep_short_code' => 'required|max:2|min:2|unique:ecommerce_partners,ep_short_code,' . $request->ep_id,
            'email' => 'required|email|unique:ecommerce_partners,email,' . $request->ep_id,
            'password' => "$password_rule",
            'address' => 'required',
            'contact_number' => 'required|max:15',
            'contact_person' => 'required|max:255',
            'image' => '',

            'ep_url' => 'required|url|unique:ecommerce_partners,ep_url,' . $request->ep_id,
            'product_search_url' => 'required|url|unique:ecommerce_partners,product_search_url,' . $request->ep_id,
            'auth_check_url' => 'required|url|unique:ecommerce_partners,auth_check_url,' . $request->ep_id,
            'place_order_api_url' => 'required|url|unique:ecommerce_partners,place_order_api_url,' . $request->ep_id,

            'ep_commission' => '',
            'udc_commission' => '',
        ]);

        if ($validator->fails()) {
            return redirect("admin/edit-ep/$request->ep_id")->withErrors($validator)->withInput();
        } else {

            $ecommerce_partner = EcommercePartner::find($request->ep_id);
            if (!$ecommerce_partner)
                return redirect('admin/all-ep');


            //image upload
            $images = $request->file('image');
            if ($images) {
                $util = new PlxUtilities();
                $file_name = $util->create_clean_url($request->ep_name) . '-' . rand(1, 9) . date("s") . '-logo.png';
                $request->request->add(['ep_logo' => $file_name]);
                $to = 'public/content-dir/ecommerce_partners/';
                $images->move($to, $file_name);
            }
            //end image upload

            $ecommerce_partner->update($request->all());

            return redirect("admin/all-ep");
        }
    }

    public function change_status(Request $request)
    {
        $data = array();
        if ($request->status && $request->epid) {
            $get_ep = EcommercePartner::find($request->epid);
            $get_ep->status = $request->status;
            $get_ep->save();
            if ($request->status == 1) {
                $status = 'Active';
                $status_text = '<a href="javascript:void(0)" class="btn blue btn-xs change-status" data-status="2" data-epid="' . $request->epid . '">Deactivate</a>';
            } else {
                $status = 'Inactive';
                $status_text = '<a href="javascript:void(0)" class="btn blue btn-xs change-status" data-status="1" data-epid="' . $request->epid . '">Activate</a>';
            }
            $data['status'] = $status;
            $data['status_text'] = $status_text;
            return json_encode($data);
        }
    }

    public function payments(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['ep_management'] = 'start active open';
        $data['ep_payment'] = 'active';

        $data['udc_list'] = User::where('status', '=', 1)->get();

        $input = $request->all();

        $data['udc_payments'] = Order::paginate($this->row_per_page);

        return view('admin.not-found')->with($data);

//        if ($request->ajax()) {
//            return Response::json(View::make('admin.ekom.ep.payment.render_ep_payments', $data)->render());
//        } else {
//            return view('admin.ekom.ep.payment.ep_payments')->with($data);
//        }
    }

    public function paymentDetails(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['ep_management'] = 'start active open';
        $data['ep_payment'] = 'active';
        return view('admin.ekom.ep.payment.ep_payment_details')->with($data);
    }

    public function reports()
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['ep_management'] = 'start active open';
        $data['ep_report'] = 'active';
//        return view('admin.ekom.ep.report.report')->with($data);
        return view('admin.not-found')->with($data);
    }

    public function orders(Request $request, $id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['ep_management'] = 'start active open';
        $data['all_ep'] = 'active';
        $data['url'] = url("admin/ep/$id/orders");

        $data['ep_info'] = EcommercePartner::find($id);
        if (!$data['ep_info']) {
            return redirect('admin/all-ep');
        }

        //Change Order Status
        if ($request->order_code) {
            $change_status = new ChangeOrderStatus();
            $change_status->change_order_status($request->order_code);
        }

        $data['limit'] = $limit = $request->limit?$request->limit:15;
        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $limit) + 1 : 1;

        $data['all_orders'] = Order::where('ep_id', '=', $id);

        if ($request->search_string || $request->from || $request->to) {

            if ($request->to == '')
                $request->to = Carbon::now();

            $data['all_orders'] = $data['all_orders']->where(function ($query) use ($request) {
                if (@$request->from)
                    $query->where('created_at', '>=', @$request->from . ' 00:00:00');

                if (@$request->to)
                    $query->where('created_at', '<=', @$request->to . ' 23:59:59');

            })->where(function ($query) use ($request) {

                $query->where('order_code', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('lp_name', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('ep_name', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('delivery_location', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('receiver_name', 'LIKE', '%' . $request->search_string . '%')
                    ->orWhere('receiver_contact_number', 'LIKE', '%' . $request->search_string . '%');
            });
        }

        if (isset($request->tab_id) && $request->tab_id != 'all' && $request->tab_id != '6') {
            $data['all_orders'] = $data['all_orders']->where('status', '=', $request->tab_id);
        } else if ($request->tab_id == '6') {
            $data['all_orders'] = $data['all_orders']->where('ep_order_id', null);
        }

        $data['total_price'] = $data['all_orders']->sum('total_price');
        $data['total_commission'] = $data['all_orders']->sum('udc_commission');
        $data['total_orders'] = $data['all_orders']->count();

        $data['all_orders'] = $data['all_orders']->orderBy('id', 'desc');
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
            $this->createExportFile($writer, $data['all_orders'], $filePath);
            return Response::download($filePath, $file_name);

        } else if (@$request->export_type == 'xlsx') {

            $writer = WriterFactory::create(Type::XLSX);
            $file_name = "order_list-" . date("YmdHis") . ".xlsx";
            $filePath = base_path("tmp/" . $file_name);
            $adb = File::put($filePath, '');
            $this->createExportFile($writer, $data['all_orders'], $filePath);
            return Response::download($filePath, $file_name);

        }


        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.orders.render_ep_order_list', $data)->render());
        } else {
            return view('admin.ekom.orders.ep_order_list')->with($data);
        }
    }


    public function createExportFile($writer, $orders, $filePath)
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
	
	  public function disburesed_commission_list(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['reports_management'] = 'start active open';
        $data['disbursed_udc_commission'] = 'active';

        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $this->row_per_page) + 1 : 1;


        if ($request->from && $request->to && $request->ep_id) {

            if ($request->from) {
                $data['from'] = $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
            } else {
                $data['from'] = $from = Carbon::now()->startOfMonth();
            }

            if ($request->to) {
                $data['to'] = $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->to 23:59:59")));
            } else {
                $data['to'] = $to = Carbon::now()->startOfMonth();
            }

            $monthDiff = date('m', strtotime($data['to'])) - date('m', strtotime($data['from']));
            $data['month'] = $request->from && $request->from == "all" ? $request->from : $monthDiff > 1 ? 'all' : date('m', strtotime($data['from']));
            $data['year'] = $request->to && $request->to == "all" ? $request->to : date('Y', strtotime($data['from']));
            $data['epId'] = $request->ep_id;

            $data['to'] = $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$to")));
            $data['ep_info'] = $ep_info = EcommercePartner::where('id', $request->ep_id)->first();

            $data['ep_name'] = $request->ep_id &&  $request->ep_id == 'all' ? "All EP" : $data['ep_info']->ep_name;
            $data['ep_id'] = $request->ep_id;

            $data['disbursed_commission_list'] = CommissionDisbursementHistory::where(function ($q) use ($data, $request) {
                if(@$request->from != 'all'){
                    $q->where("disbursement_from_date", ">=", $data['from']);
                    $q->where("disbursement_to_date", "<=", $data['to']);
                }if ($request->search_string && $request->search_string != 'undefined') {
                    $q->whereHas('udc', function ($query) use ($request) {
                        $query->where('name_bn', 'LIKE', '%' . $request->search_string . '%')
                            ->orWhere('name_en', 'LIKE', '%' . $request->search_string . '%')
                            ->orWhere('contact_number', 'LIKE', '%' . $request->search_string . '%');
                    })->orderBy('id', 'desc')->paginate($this->row_per_page);
                }if (@$request->ep_id != 'all') {
                    $q->where("ep_id", $data['ep_info']->id);
                }})->orderBy('id', 'desc')->paginate($this->row_per_page);

            $ep_id = @$data['ep_info']->id;
            $total_disbursed_amount = 0;
            if (@$request->export_type == 'csv') {
                $writer = WriterFactory::create(Type::CSV);
                $file_name = "commission-report-" . date("YmdHis") . ".csv";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');

                $writer->openToFile($filePath);
                $writer->addRow(array("Slno", "UDC Name", "Contact Number", "EP Name",  "Disbursed Amount", "Disbursed Date", "Selected Month"));

                foreach ($data['disbursed_commission_list'] as $key => $each_commission) {
                    $total_disbursed_amount += @$each_commission->amount;
                    $writer->addRow(array(
                        $key + 1,
                        @$each_commission->udc->name_bn,
                        @$each_commission->udc->contact_number,
                        @$each_commission->ep_info->ep_name,
                        number_format(@$each_commission->amount),
                        date('M d, Y', strtotime(@$each_commission->created_at)),
                        date('F', strtotime(@$each_commission->disbursement_from_date))
                    ));
                }

                $writer->addRow(array("", "", "", "", "", "", "", ""));
                $writer->addRow(array("", "", "", "", "Total Disbursed Amount"));
                $writer->addRow(array("", "", "", "", number_format($total_disbursed_amount, 0)));
                $writer->close();
                return Response::download($filePath, $file_name);

            } else if (@$request->export_type == 'xlsx') {

                $writer = WriterFactory::create(Type::XLSX);
                $file_name = "commission-report-" . date("YmdHis") . ".xlsx";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');
                $writer->openToFile($filePath);
                $writer->addRow(array("Slno", "UDC Name", "Contact Number", "EP Name",  "Disbursed Amount", "Disbursed Date", "Selected Month"));

                foreach ($data['disbursed_commission_list'] as $key => $each_commission) {

                    $total_disbursed_amount += @$each_commission->amount;

                    $writer->addRow(array(
                        $key + 1,
                        @$each_commission->udc->name_bn,
                        @$each_commission->udc->contact_number,
                        @$each_commission->ep_info->ep_name,
                        number_format(@$each_commission->amount),
                        date('M d, Y', strtotime(@$each_commission->created_at)),
                        date('F', strtotime(@$each_commission->disbursement_from_date))
                    ));
                }
                $writer->addRow(array("", "", "", "", "", "", "", ""));
                $writer->addRow(array("", "", "", "", "Total Disbursed Amount"));
                $writer->addRow(array("", "", "", "", number_format($total_disbursed_amount, 0)));
                $writer->close();
                return Response::download($filePath, $file_name);

            }
        }else{
            $data['disbursed_commission_list'] = CommissionDisbursementHistory::where(function ($q) use ($data, $request) {if ($request->search_string) {
                    $q->whereHas('udc', function ($query) use ($request) {
                        $query->where('name_bn', 'LIKE', '%' . $request->search_string . '%')
                            ->orWhere('name_en', 'LIKE', '%' . $request->search_string . '%')
                            ->orWhere('contact_number', 'LIKE', '%' . $request->search_string . '%');
                    })->orderBy('id', 'desc')->paginate($this->row_per_page);
                }})->orderBy('id', 'desc')->paginate($this->row_per_page);
        }

        $data['all_eps'] = EcommercePartner::all();

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.reports.render-disbursed-commission-list', $data)->render());
        } else {
            return view('admin.ekom.reports.disburesed-commission-list')->with($data);
        }
    }

    public function disburesement_invoice(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['reports_management'] = 'start active open';
        $data['commission_overview'] = 'active';

        $get_disbursed = CommissionDisbursementHistory::find($request->id);

        $data['disbursed_info'] = $disbursed_info = CommissionDisbursementHistory::with(['udc_orders' => function ($query) use ($get_disbursed) {
            $query->where("created_at", ">=", $get_disbursed->disbursement_from_date);
            $query->where("created_at", "<=", $get_disbursed->disbursement_to_date);
            $query->where('ep_id', $get_disbursed->ep_id);
            $query->where('user_id', $get_disbursed->udc_id);
            $query->where('is_commission_disburesed', '=', 1);
            $query->where('status', '!=', 5);
        }])->where('id', $request->id)->first();

        return view('admin.ekom.reports.disburesement-invoice')->with($data);
    }

    public function commission_overview(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['reports_management'] = 'start active open';
        $data['commission_overview'] = 'active';

        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $this->row_per_page) + 1 : 1;

        if ($request->from && $request->to && $request->ep_id) {

            if ($request->from) {
                $data['from'] = $from = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->from 00:00:00")));
            } else {
                $data['from'] = $from = Carbon::now()->startOfMonth();
            }

            if ($request->to) {
                $data['to'] = $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$request->to 23:59:59")));
            } else {
                $data['to'] = $to = Carbon::now()->startOfMonth();
            }

            $data['to'] = $to = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("$to")));
            $data['ep_info'] = $ep_info = EcommercePartner::where('id', $request->ep_id)->first();

            $data['ep_name'] = $request->ep_id && $request->ep_id == 'all' ? "All EP" : $data['ep_info']->ep_name;
            $data['startDate'] = $request->from && $request->from == "all" ? $request->from : $from;
            $data['endDate'] = $request->to && $request->to == "all" ? $request->to : $to;
            $data['ep_id'] = $request->ep_id;

            $data['udc_order_reports'] = User::whereHas('orders', function ($q) use ($data, $request) {

                $q->where("status", '>', 1);
                $q->where("status", '!=', 5);
                if (@$request->ep_id != 'all') {
                    $q->where("ep_id", $data['ep_info']->id);
                }
                if ($request->search_string && $request->search_string != 'undefined') {
                    $q->where('name_bn', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('name_en', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('center_id', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('center_name', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('entrepreneur_id', 'LIKE', '%' . $request->search_string . '%')
                        ->orWhere('contact_number', 'LIKE', '%' . $request->search_string . '%');
                }
            })->with(['orders' => function ($q) use ($data, $request) {

                if (@$request->from != 'all') {
                    $q->where("created_at", ">=", $data['from']);
                    $q->where("created_at", "<=", $data['to']);
                }
                $q->where("status", '>', 1);
                $q->where("status", '!=', 5);
                if (@$request->ep_id != 'all') {
                    $q->where("ep_id", $data['ep_info']->id);
                }
            }])->orderBy('id', 'desc');

            if (@$request->export_type) {
                $data['udc_order_reports'] = $data['udc_order_reports']->get();
            } else {
                $data['udc_order_reports'] = $data['udc_order_reports']->paginate($this->row_per_page);
            }

            $data['total_orders'] = Order::where( function ($q) use ($data, $from, $to, $request) {
                    if (@$request->from != 'all') {
                        $q->where("created_at", ">=", $from);
                        $q->where("created_at", "<=", $to);
                    }
                    $q->where('status', '!=', 5);
                    $q->where("status", '>', 1);
                    if (@$request->ep_id != 'all') {
                        $q->where("ep_id", $data['ep_info']->id);
                    }
                })->get()->count();

            $data['total_sales'] = Order::where(function ($q) use ($data, $from, $to, $request) {
                if (@$request->from != 'all') {
                    $q->where("created_at", ">=", $from);
                    $q->where("created_at", "<=", $to);
                }
                $q->where('status', '!=', 5);
                $q->where("status", '>', 1);
                if (@$request->ep_id != 'all') {
                    $q->where("ep_id", $data['ep_info']->id);
                }
            })->get()->sum('total_price');

            $data['total_commission'] = Order::where(function ($q) use ($data, $from, $to, $request) {
                if (@$request->from != 'all') {
                    $q->where("created_at", ">=", $from);
                    $q->where("created_at", "<=", $to);
                }
                $q->where('status', '!=', 5);
                $q->where("status", '>', 1);
                if (@$request->ep_id != 'all') {
                    $q->where("ep_id", $data['ep_info']->id);
                }
            })->get()->sum('udc_commission');

            $ep_id = @$data['ep_info']->id;

            $total_udc_commission = 0;
            $total_paid_commission = 0;
            $total_due_commission = 0;

            if (@$request->export_type == 'csv') {

                $writer = WriterFactory::create(Type::CSV);
                $file_name = "commission-report-" . date("YmdHis") . ".csv";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');

                $writer->openToFile($filePath);
                $writer->addRow(array("Slno", "UDC Name", "Total Commission", "Paid Commission", "Due Commission"));

                foreach ($data['udc_order_reports'] as $key => $each_udc) {

                    $this_udc_commission = $each_udc->orders->where('status', '!=', 5)->sum('udc_commission');
                    $total_udc_commission += $this_udc_commission;

                    $this_udc_paid_commission = $each_udc->orders->where('status', '!=', 5)->where('is_commission_disburesed', '=', 1)->sum('udc_commission');//PAID COMMISSION
                    $total_paid_commission += $this_udc_paid_commission;

                    $this_udc_due_commission = $each_udc->orders->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->sum('udc_commission'); //DUE COMMISSION
                    $total_due_commission += $this_udc_due_commission;

                    if ($ep_id) {
                        $user_orders = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('ep_id', $ep_id);
                    } else {
                        $user_orders = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5);
                    }
                    $writer->addRow(array(
                        $key + 1,
                        @$each_udc->name_bn,
                        number_format($user_orders->sum('udc_commission')),
                        number_format(@$this_udc_paid_commission, 0),
                        number_format(@$this_udc_due_commission, 0)
                    ));
                }

                $writer->addRow(array("", "", "", "", "", "", "", ""));
                $writer->addRow(array("", "", "Total Commission", "Total Paid Commission", "Total Due Commission"));
                $writer->addRow(array("", "", number_format($total_udc_commission, 0), number_format($total_paid_commission, 0), number_format($total_due_commission, 0)));
                $writer->close();
                return Response::download($filePath, $file_name);

            } else if (@$request->export_type == 'xlsx') {

                $writer = WriterFactory::create(Type::XLSX);
                $file_name = "commission-report-" . date("YmdHis") . ".xlsx";
                $filePath = base_path("tmp/" . $file_name);
                $adb = File::put($filePath, '');

                $writer->openToFile($filePath);

                $writer->addRow(array("Slno", "UDC Name", "Total Commission", "Paid Commission", "Due Commission"));

                foreach ($data['udc_order_reports'] as $key => $each_udc) {

                    $this_udc_commission = $each_udc->orders->where('status', '!=', 5)->sum('udc_commission');
                    $total_udc_commission += $this_udc_commission;

                    $this_udc_paid_commission = $each_udc->orders->where('status', '!=', 5)->where('is_commission_disburesed', '=', 1)->sum('udc_commission');//PAID COMMISSION
                    $total_paid_commission += $this_udc_paid_commission;

                    $this_udc_due_commission = $each_udc->orders->where('status', '!=', 5)->where('is_commission_disburesed', '=', 0)->sum('udc_commission'); //DUE COMMISSION
                    $total_due_commission += $this_udc_due_commission;

                    if ($ep_id) {
                        $user_orders = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5)->where('ep_id', $ep_id);
                    } else {
                        $user_orders = $each_udc->orders->where("status", '>', 1)->where('status', '!=', 5);
                    }
                    $writer->addRow(array(
                        $key + 1,
                        @$each_udc->name_bn,
                        number_format($user_orders->sum('udc_commission')),
                        number_format(@$this_udc_paid_commission, 0),
                        number_format(@$this_udc_due_commission, 0)
                    ));
                }
                $writer->addRow(array("", "", "", "", "", "", "", ""));
                $writer->addRow(array("", "", "Total Commission", "Total Paid Commission", "Total Due Commission"));
                $writer->addRow(array("", "", number_format($total_udc_commission, 0), number_format($total_paid_commission, 0), number_format($total_due_commission, 0)));
                $writer->close();
                return Response::download($filePath, $file_name);
            }
        }

        $data['all_eps'] = EcommercePartner::all();

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.render_udc_commission_report', $data)->render());
        } else {
            return view('admin.ekom.udc_commission_report')->with($data);
        }
    }
}
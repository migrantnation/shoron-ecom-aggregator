<?php

namespace App\Http\Controllers\admin\ekom;

use App\Libraries\ChangeOrderStatus;
use App\Libraries\EkomEncryption;
use App\Libraries\PlxUtilities;
use App\Libraries\Slim;
use App\models\CountryLocation;
use App\models\LogisticPartner;
use App\models\LpShippingPackage;
use App\models\Order;
use App\models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use App\models\UdcCustomer;
use DB;
use Validator;


use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Illuminate\Support\Facades\File;

class LogisticPartnerController extends Controller
{

    public $row_per_page = 10;


    public function lpList()
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        return view('admin.ekom.lp.lp_list')->with($data);
    }

    public function lpCreate()
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['lp_management'] = 'start active open';
        $data['all_lp'] = 'active';
        return view('admin.ekom.lp.lp_edit')->with($data);
    }

    public function edit($id)
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['lp_management'] = 'start active open';
        $data['all_lp'] = 'active';
        $data['locations'] = CountryLocation::where('tree_level', 0)->get();
        $data['users'] = User::orderBy('division', 'asc')->get();
        $data['lp'] = LogisticPartner::where('id', $id)->with('packages')->first();
        return view('admin.ekom.lp.lp_edit')->with($data);
    }

    public function package_location(Request $request)
    {
        $data = array();
        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $this->row_per_page) + 1 : 1;
        $data['lp'] = LogisticPartner::where('id', $request->lp_id)->with('packages')->first();
        $data['users'] = User::where('entrepreneur_id', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('contact_number', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('center_name', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('center_id', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('email', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('division', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('district', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('upazila', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('union', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('id', $request->search_string)
            ->orderBy('division', 'asc')
            ->paginate($this->row_per_page);
        return Response::json(View::make('admin.ekom.lp.package_list', $data)->render());
    }

    public function lpStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lp_name' => 'required|unique:logistic_partners',
            'lp_short_code' => 'required|unique:logistic_partners',
            'lp_url' => 'required|unique:logistic_partners',
            'lp_logo' => 'required',
            'email' => 'required|string|email|max:255|unique:logistic_partners',
            'password' => 'required|string|min:6|confirmed',
            'contact_person' => 'required|max:255',
            'contact_number' => 'required|max:15',
            'address' => 'required',
            'charge' => '',
            'lp_commission' => '',
            'place_order_api_url' => 'required|url|unique:logistic_partners',
            'order_status_change_api' => 'url|unique:logistic_partners',
            'api_secret' => '',
            'api_key' => '',
            'api_user_id' => '',
            'api_password' => '',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $encryption = new EkomEncryption();
        $access_token = $encryption->encrypt(sha1($request->contact_person . md5($request->email)));
        $lp = new LogisticPartner();
        $lp->lp_name = $request->lp_name;
        $lp->contact_person = $request->contact_person;
        $lp->contact_number = $request->contact_number;
        $lp->email = $request->email;
        $lp->access_token = $access_token;
        $lp->address = $request->address;
        $lp->charge = $request->charge;
        $lp->lp_commission = $request->lp_commission;

        //LP API INFORMATION
        $lp->lp_url = $request->lp_url;
        $lp->place_order_api_url = $request->place_order_api_url;
        $lp->order_status_change_api = $request->order_status_change_api;
        $lp->api_secret = $request->api_secret;
        $lp->api_key = $request->api_key;
        $lp->api_user_id = $request->api_user_id;
        $lp->api_password = $request->api_password;

        //image upload
        $images = $request->file('lp_logo');
        if ($images) {
            $util = new PlxUtilities();
            $file_name = $util->create_clean_url($request->lp_name) . '-' . rand(1, 9) . date("s") . '-logo.png';
            $to = 'public/content-dir/logistic_partners/';
            $images->move($to, $file_name);
            $lp->lp_logo = $file_name;
        }
//        echo "<img src='$to/$file_name'/> ";
//        dd();
        //end image upload


        $digits = 5;
        do {
            $lp_code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $lp_code_exist = LogisticPartner::where('lp_code', $lp_code)->get();
        } while (!$lp_code_exist);

        $lp->lp_short_code = $request->lp_short_code;
        $lp->lp_code = $lp_code;
        $lp->password = bcrypt($request->password);

        if ($lp->save()) {
//            $mail = Mail::to($lp->email)->send(new LpCreate($lp->lp_name));
            return redirect('admin/lp-list')->with('message', 'Successful');
        }

        return redirect('admin/lp-list')->with('message', 'Something Wrong');
    }


    public function update(Request $request, $id)
    {
        if ($request->password) {
            $password_rule = 'min:6|confirmed';
        } else {
            $password_rule = '';
        }

        $validator = Validator::make($request->all(), [
            'lp_name' => 'required|unique:logistic_partners,lp_name,' . $id,
            'lp_short_code' => 'required|unique:logistic_partners,lp_short_code,' . $id,
            'lp_logo' => '',
            'email' => 'required|string|email|max:255|unique:logistic_partners,email,' . $id,
            'password' => "$password_rule",
            'contact_person' => 'required|max:255',
            'contact_number' => 'required|max:15',
            'address' => 'required',
            'charge' => '',
            'lp_commission' => '',

            'lp_url' => 'required|unique:logistic_partners,lp_url,' . $id,
            'place_order_api_url' => 'required|url|unique:logistic_partners,place_order_api_url,' . $id,
            'order_status_change_api' => 'url|unique:logistic_partners,order_status_change_api,' . $id,
            'api_secret' => '',
            'api_key' => '',
            'api_user_id' => '',
            'api_password' => ''

        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $lp = LogisticPartner::find($id);
        $lp->lp_name = $request->lp_name;
        $lp->contact_person = $request->contact_person;
        $lp->contact_number = $request->contact_number;
        $lp->email = $request->email;
        $lp->address = $request->address;
        $lp->charge = $request->charge;
        $lp->lp_commission = $request->lp_commission;

        //LP API INFORMATION
        $lp->lp_url = $request->lp_url;
        $lp->place_order_api_url = $request->place_order_api_url;
        $lp->order_status_change_api = $request->order_status_change_api;
        $lp->api_secret = $request->api_secret;
        $lp->api_key = $request->api_key;
        $lp->api_user_id = $request->api_user_id;
        $lp->api_password = $request->api_password;

        //image upload
        $images = $request->file('lp_logo');
        if ($images) {
            $util = new PlxUtilities();
            $file_name = $util->create_clean_url($request->lp_name) . '-' . rand(1, 9) . date("s") . '-logo.png';
            $to = 'public/content-dir/logistic_partners/';
            $images->move($to, $file_name);

            $lp_logo = "public/content-dir/logistic_partners/$lp->lp_logo";
            if (is_file($lp_logo)) {
                unlink($lp_logo);
            }
            $lp->lp_logo = $file_name;
        }
        //end image upload


        $lp->lp_short_code = $request->lp_short_code;

        if ($request->password) {
            $lp->password = bcrypt($request->password);
        }

        $lp->save();

        return redirect('admin/lp-list')->with('message', 'Update Successful');
    }

    public function delete($id)
    {
        $lp = LogisticPartner::destroy([$id]);
        if ($lp) {
            return back()->with('message', 'Deleted Successfully.');
        } else {
            return 'Something Wrong';
        }
    }


    public function lp_package_list(Request $request, $lp_id)
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['lp_management'] = 'start active open';
        $data['all_lp'] = 'active';

        $data['locations'] = CountryLocation::where('tree_level', 0)->get();
        
        
        /*$data['users'] = User::with(['udc_package_list' => function ($q) {
            $q->with(['logistic_partner']);
        }])->orderBy('division', 'asc')
            ->get();*/
            
        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $this->row_per_page) + 1 : 1;
        
        $data['users'] = User::where('entrepreneur_id', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('contact_number', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('center_name', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('center_id', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('email', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('division', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('district', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('upazila', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('union', 'LIKE', '%' . $request->search_string . '%')
            ->orWhere('id', $request->search_string)
            ->orderBy('division', 'asc')
            ->paginate($this->row_per_page);
			
		
        //$data['searched_user'] = User::where('id', $request->search_string )->get();
			
        $data['lp'] = LogisticPartner::where('id', $lp_id)->with('packages')->first();

        return view('admin.ekom.lp.packages')->with($data);
    }


    public function save_package(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        $utility = new PlxUtilities();

        $validator = Validator::make($request->all(), [
            'lp_id' => 'required',
            'location_id' => 'required',
            'price' => 'required',
            'delivery_duration' => 'required',
            'package_code' => '',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            $utility->json($status, $response);
        }

        $lp_id = $request->lp_id;
        $location_id = $request->location_id;
        $price = $request->price;
        $delivery_duration = $request->delivery_duration;
        $package_code = $request->package_code;

        $lpShippingPackage = LpShippingPackage::where('location_id', $location_id)->where('lp_id', $lp_id)->first();
        if ($lpShippingPackage) {
            $lpShippingPackage->lp_id = $lp_id;
            $lpShippingPackage->location_id = $location_id;
            $lpShippingPackage->delivery_duration = $delivery_duration;
            $lpShippingPackage->price = $price;
            $lpShippingPackage->package_code = $package_code;
            $lpShippingPackage->is_selected = 1;
            $lpShippingPackage->updated_by = "_ecom_ Admin";
            $lpShippingPackage->save();
        } else {
            $lpShippingPackage = new LpShippingPackage();
            $lpShippingPackage->lp_id = $lp_id;
            $lpShippingPackage->location_id = $location_id;
            $lpShippingPackage->delivery_duration = $delivery_duration;
            $lpShippingPackage->price = $price;
            $lpShippingPackage->package_code = $package_code;
            $lpShippingPackage->is_selected = 1;
            $lpShippingPackage->updated_by = "_ecom_ Admin";
            $lpShippingPackage->save();
        }

        $data['users'] = User::with(['udc_package_list' => function ($q) {
            $q->with(['logistic_partner']);
        }])->where('id', $request->location_id)
//            ->get();
            ->paginate($this->row_per_page);

        $user_info = User::where('id', $request->location_id)->first();
        $user_info->status = 1;
        $user_info->save();

        $data['lp'] = LogisticPartner::where('id', $request->lp_id)->with(['packages' => function ($q) use ($request) {
            $q->where('location_id', $request->location_id);
        }])->first();

        $status = 200;
        $response['message'] = "Package information has been updated successfully";
        $response['view'] = View::make('admin.ekom.lp.package_list', $data)->render();

        $utility->json($status, $response);
    }

    public function change_package_status(Request $request)
    {

        $status = 100;
        $response = array();
        $response['message'] = '';
        $utility = new PlxUtilities();

        $validator = Validator::make($request->all(), [
            'lp_id' => 'required',
            'location_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            $utility->json($status, $response);
        }

        $lpShippingPackage = LpShippingPackage::where('location_id', $request->location_id)->where('lp_id', $request->lp_id)->first();
        $lpShippingPackage->is_selected = $request->status;
        $lpShippingPackage->updated_by = "_ecom_ Admin";
        $lpShippingPackage->save();

        $data['users'] = User::with(['udc_package_list' => function ($q) {
            $q->with(['logistic_partner']);
        }])->orderBy('division', 'asc')->paginate($this->row_per_page);

        $user_actiuve_package = LpShippingPackage::where('location_id', $request->location_id)
            ->where('is_selected', 1)->get();
        if ($user_actiuve_package->count() == 0) {
            $user_info = User::where('id', $request->location_id)->first();
            $user_info->status = 2;
            $user_info->save();
        }

        $data['lp'] = LogisticPartner::where('id', $request->lp_id)->with(['packages' => function ($q) use ($request) {
            $q->where('location_id', $request->location_id);
        }])->first();

        $status = 200;
        $response['message'] = "Package status has been updated successfully";
        $response['view'] = View::make('admin.ekom.lp.package_list', $data)->render();

        $utility->json($status, $response);
    }

    public function change_status(Request $request)
    {
        $data = array();
        if ($request->status && $request->lpid) {
            $get_lp = LogisticPartner::find($request->lpid);
            $get_lp->status = $request->status;
            $get_lp->save();
            if ($request->status == 1) {
                $status = 'Active';
                $status_text = '<a href="javascript:void(0)" class="btn blue btn-xs change-status" data-status="2" data-lpid="' . $request->lpid . '">Deactivate</a>';
            } else {
                $status = 'Inactive';
                $status_text = '<a href="javascript:void(0)" class="btn blue btn-xs change-status" data-status="1" data-lpid="' . $request->lpid . '">Activate</a>';
            }
            $data['status'] = $status;
            $data['status_text'] = $status_text;
            return json_encode($data);
        }
    }

    public function lp_list(Request $request)
    {
        $input = $request->all();
        $data = array(
            'side_bar' => 'ekom_side_bar',
            'header' => 'header',
            'footer' => 'footer',
            'all_lp' => 'active',
            'lp_management' => 'start active open');
        $data['division'] = CountryLocation::where('parent_id', 0)->get();

        $data['lp_list'] = LogisticPartner::where('status', '!=', '4')->get();

        if (isset($input['search_string'])) {
            $sstring = $input['search_string'];
            $data['lp_list'] = LogisticPartner::where('lp_name', 'LIKE', '%' . $sstring . '%')
                ->orWhere('contact_number', '=', $sstring)
                ->orWhere('email', 'LIKE', '%' . $sstring . '%')
                ->orWhere('address', 'LIKE', '%' . $sstring . '%')
                ->paginate($this->row_per_page)->withPath('?search_string=' . $sstring);
        } else {
            $data['lp_list'] = LogisticPartner::where('status', '!=', '4')->paginate($this->row_per_page);
        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.lp.render-lp-list', array('lp_list' => $data['lp_list']))->render());
        } else {
            return view('admin.ekom.lp.lp_list')->with($data);
        }
    }

    public function lpProfile($lp_url)
    {
        $data = array('menu' => '', 'side_bar' => 'ekom_side_bar', 'header' => 'header', 'footer' => 'footer',
            'lp_management' => 'start active open');

        $data['lp_info'] = $lp_info = LogisticPartner::where('lp_url', '=', $lp_url)->first();
        $data['lp_orders'] = Order::with(['customer'])->where('lp_id', '=', $lp_info->id)->limit(5)->get();
        $data['shipping_packages'] = LpShippingPackage::where('lp_id', '=', $lp_info->id)->limit(5)->get();

        return view('admin.ekom.lp.profile.profile')->with($data);
    }

    public function lpOrders(Request $request, $id)
    {
        $data = array();
        $data['menu'] = '';
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['lp_management'] = 'start active open';
        $data['lp'] = LogisticPartner::where('id', $id)->first();

        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $this->row_per_page) + 1 : 1;

        $input = $request->all();
        $data['url'] = url("admin/lp/$id/orders");

        $data['limit'] = $limit = $request->limit;

        //Change Order Status
        if ($request->order_code) {
            $change_status = new ChangeOrderStatus();
            $change_status->change_order_status($request->order_code);
        }

        if ($request->search_string || $request->from || $request->to) {
            if ($request->to == '') {
                $request->to = Carbon::now();
            }

            $data['all_orders'] = Order::where('lp_id', '=', $id)
                ->where(function ($query) use ($request) {
                    if (isset($request->tab_id) && $request->tab_id != 'all') {
                        $query->where('status', $request->tab_id);
                    }

                    if (@$request->from != '') {
                        $query->where('created_at', '>=', @$request->from . ' 00:00:00');
                    }
                    if (@$request->to != '') {
                        $query->where('created_at', '<=', @$request->to . ' 23:59:59');
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
                $data['all_orders'] = Order::where('lp_id', '=', $id)->where('status', '=', $request->tab_id)->orderBy('id', 'desc');
            } else {
                $data['all_orders'] = Order::where('lp_id', '=', $id)->orderBy('id', 'desc');
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


    public function order_details($order_id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['lp_management'] = 'start active open';
        $data['all_lp'] = 'active';

        $data['order_info'] = Order::with(['order_details', 'order_invoice', 'lp_info', 'UdcCustomer'])->where('id', $order_id)->first();
        $data['user_info'] = $user_info = User::find($data['order_info']->user_id);
        if ($data['order_info']) {
            $data['udcCustomers'] = UdcCustomer::where('udc_id', $data['order_info']->user_id)->get();
            return view('admin.ekom.udc.order-details')->with($data);
        } else {
            return redirect('');
        }
    }


    public function paymentDetails(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['lp_management'] = 'start active open';
        $data['lp_payment'] = 'active';
        return view('admin.ekom.lp.payment.lp_payment_details')->with($data);
    }

    public function payments(Request $request)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['lp_management'] = 'start active open';
        $data['lp_payment'] = 'active';

        $data['udc_list'] = User::where('status', '=', 1)->get();

        $input = $request->all();

        $data['udc_payments'] = Order::paginate($this->row_per_page);

        return view('admin.not-found')->with($data);

//        if ($request->ajax()) {
//            return Response::json(View::make('admin.ekom.lp.payment.render_lp_payments', $data)->render());
//        } else {
//            return view('admin.ekom.lp.payment.lp_payments')->with($data);
//        }
    }

}

<?php

namespace App\Http\Controllers\admin\udc;

use App\Libraries\ChangeOrderStatus;
use App\Libraries\PlxUtilities;
use App\models\Order;
use App\models\OrderTrack;
use App\models\UdcCustomer;
use App\models\User;
use App\models\UserActivitiesLog;
use Validator;
use App\LoginInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class OrderManagementController extends Controller
{

    public $row_per_page = 10;

    public function purchases(Request $request)
    {
        $data = array();
        $input = $request->all();
        $data['menu'] = 'purchases';
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        $data['purchases'] = 'start active open';
        $data['purchase_list'] = 'active';
        $data['page'] = $request->page && $request->page > 1 ? (($request->page - 1) * $this->row_per_page) + 1 : 1;
        $data['url'] = url("udc/purchases");

        //Change Order Status
//        if ($request->order_code) {
//            $change_status = new ChangeOrderStatus();
//            $change_status->change_order_status($request->order_code);
//
//
//            //CREATE ACTIVITY
//            $order_info = Order::where('order_code', $request->order_code)->with(['lp_info'])->first();
//            $user_activity = new UserActivitiesLog();
//            $user_activity->type = "34";
//            $user_activity->message = $order_info->lp_info->lp_name . " has delivered a product";
//            $user_activity->ids = $order_info->lp_info->id;
//            $user_activity->save();
//        }
        $exception_array = array(6912,6913,6914,6915,6916,6917,6918,6919,6920,6921,6922);

        if ($request->search_string || $request->from || $request->to) {
            if ($request->from != '' && $request->to == '') {
                $request->to = Carbon::now();
            }

            $data['all_orders'] = Order::whereNotIn('id', $exception_array)->where('user_id', Auth::user()->id)
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

                })
                ->orWhere(function ($query) use ($request) {
                    $query->with(['UdcCustomer' => function ($query) use ($request) {
                        $query->where('customer_name', 'like', '%' . $request->search_string . '%');
                    }]);

                })->orderBy('id', 'desc')->paginate($this->row_per_page)->withPath('?search_string=' . $input['search_string']);

        } else {
            if (isset($request->tab_id) && $request->tab_id != 'all') {
                $data['all_orders'] = Order::whereNotIn('id', $exception_array)->where('user_id', Auth::user()->id)->where('status', '=', $request->tab_id)->with(['udc_customer'])->orderBy('id', 'desc')->paginate($this->row_per_page)->withPath('?tab_id=' . $request->tab_id);
            } else {
                $data['all_orders'] = Order::whereNotIn('id', $exception_array)->where('user_id', Auth::user()->id)->with(['udc_customer'])->orderBy('id', 'desc')->paginate($this->row_per_page)->withPath('?tab_id=all');
            }
        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.udc.render-purchase-list', $data)->render());
        } else {
            return view('admin.udc.purchase-list')->with($data);
        }
    }

    public function order_details($order_id)
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        $data['purchases'] = 'start active open';
        $data['purchase'] = 'active';

        $data['order_info'] = Order::with(['order_details', 'order_invoice', 'lp_info', 'UdcCustomer'])->where('id', $order_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($data['order_info']) {
            $data['user_info'] = $user_info = User::find($data['order_info']->user_id);
            $data['tracking_details'] = OrderTrack::where('order_id', $order_id)->get()->groupBy('status');
            $data['udcCustomers'] = UdcCustomer::where('udc_id', $data['order_info']->user_id)->get();
            return view('admin.udc.order-details')->with($data);
        } else {
            return redirect()->back();
        }
    }

    public function invoice($order_code)
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        $data['purchases'] = 'start active open';
        $data['purchase'] = 'active';

        //DC INFORMATION
        $data['user_info'] = $user_info = Auth::user();

        $data['order_info'] = Order::with(['order_details', 'order_invoice', 'lp_info', 'ep_info'])
            ->where('order_code', $order_code)
            ->where('user_id', $user_info->id)->first();

        if ($data['order_info']) {
            $data['udcCustomers'] = UdcCustomer::where('udc_id', Auth::user()->id)->get();
            return view('admin.udc.invoice')->with($data);
        } else {
            return redirect('');
        }
    }

    public function change_order_status(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        
        
        $user_info = Auth::user();
        
        //CHECKING partner SESSION TOKEN EXPIRATION
        $udc_login_info = LoginInformation::where('user_id', $user_info->id)->orderBy('id', 'desc')->first();
        $token = $udc_login_info->partner_session_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://partner.com/api/refresh/' . $token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $headers = array();
        $headers[] = "Content-type: application/json";
        $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $_partner_response = curl_exec($ch);
        $_partner_response = json_decode($_partner_response);
        
        if ($_partner_response->status === 'false') {
            $status = 200;
            $response['message'] = 'Sorry! Action has been failed due to session token expired.';
            session(['partner-session-expire' => '1']);
            Auth::logout();
        } else {
            $validator = Validator::make($request->all(), [
            'order_code' => 'required',
            'status' => 'required',
            'message' => 'required_if:status,5'
        ], [
            'order_code' => 'Order code is required',
            'status' => 'Order status is required',
            'message' => 'Valid message is required to cancel this order',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
        } else {

            if ($user_info) {

                $changable_code = array(4);

                if (!in_array($request->status, $changable_code)) {
                    $response['message'] = 'You have no access to change order status.';
                } else {
                    $order_code = $request->order_code;
                    $data["order_info"] = $order_info = Order::where('order_code', $order_code)->where('user_id', $user_info->id)->first();

                    if ($order_info) {

                        if (($request->status == 4 && $order_info->status == 1)
                            || ($request->status == 4 && $order_info->status == 2)
                            || ($request->status == 4 && $order_info->status == 3)
                        ) {

                            if ($request->status == 4 && $order_info->status == 1) {

                                $order_track = new OrderTrack();
                                $order_track->order_id = $order_info->id;
                                $order_track->status = 2;
                                $order_track->message_by = $user_info->name_en;
                                $order_track->user_type = "DC";
                                $order_track->message = "No information get from EP";
                                $order_track->save();

                                $order_track = new OrderTrack();
                                $order_track->order_id = $order_info->id;
                                $order_track->status = 3;
                                $order_track->message_by = $user_info->name_en;
                                $order_track->user_type = "DC";
                                $order_track->message = "No information get from LP";
                                $order_track->save();

                            } else if ($request->status == 4 && $order_info->status == 2) {

                                $order_track = new OrderTrack();
                                $order_track->order_id = $order_info->id;
                                $order_track->status = 3;
                                $order_track->message_by = $user_info->name_en;
                                $order_track->user_type = "DC";
                                $order_track->message = "No information get from LP";
                                $order_track->save();

                            }

                            $order_track = new OrderTrack();
                            $order_track->order_id = $order_info->id;
                            $order_track->status = $request->status;
                            $order_track->message_by = $user_info->name_en;
                            $order_track->user_type = "DC";
                            $order_track->message = "Order received by DC";
                            $order_track->save();


                            $order_info->payment_status = 3;
                            $order_info->status = $request->status;
                            $order_info->save();
                            
                            
                            //SAVE EARING TO partner
                            
                            $udc_login_info = LoginInformation::where('user_id', $user_info->id)->orderBy('id', 'desc')->first();

                            $token = $udc_login_info->partner_session_token;
                            $transaction_code = ' ';
                            $aggregate_date = date('Y-m-d');

                            $aggregate_data = array();
                            $aggregate_data['name'] = @$order_info->order_code;
                            $aggregate_data['gender'] = 0;
                            $aggregate_data['amount'] = @$order_info->udc_commission;

                            $aggregate_post = array();
                            $aggregate_post['token'] = $token;
                            $aggregate_post['transaction_code'] = $transaction_code;
                            $aggregate_post['date'] = $aggregate_date;
                            $aggregate_post['data'] = array("name"=>@$order_info->order_code,"gender"=>"1","amount"=> @$order_info->udc_commission);
                            
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, 'http://partner.com/api/save');
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($aggregate_post));
                            curl_setopt($ch, CURLOPT_POST, 1);
                            $headers = array();
                            $headers[] = "Content-type: application/json";
                            $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36";
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            $_partner_response = curl_exec($ch);
                            
                            $sent_request = curl_getinfo($ch);
                            $log_data['track'] = 'partner Save API Info';
                            $log_data['headers'] = $headers;
                            $log_data['ch'] = $sent_request;
                            $log_data['postdata'] = $aggregate_post;
                            $log_data['response'] = $_partner_response;

                            $aggregate_log_filename = 'partner-' . $order_info->order_code . '.log';
                            $order_info->ep_log = $aggregate_log_filename;
                            $this->server_log(json_encode($log_data), $aggregate_log_filename);
                            
                            Auth::logout();
                            session(['order-complete' => 'completed']);
                            

                            $user_activity = new UserActivitiesLog();
                            $user_activity->type = "34";
                            $user_activity->message = $order_info->lp_name . " has delivered a product";
                            $user_activity->ids = $order_info->lp_id;
                            $user_activity->save();

                            $status = 200;
                            $response['message'] = 'Order status has bean changed successfully.';

                        } else {
                            $order_status = array("2" => "Warehouse left", "3" => "on delivery", "4" => "delivered", "5" => "canceled");
                            $response['message'] = 'You have no access to change this order. This order already ' . @$order_status[$order_info->status];
                        }

                    } else {
                        $response['message'] = 'Order not found.';
                    }
                }
            } else {
                $status = 101;
                $response['message'] = 'Something went wrong please contact with technical support team.';
            }
        }
        
        }
        

        $utility = new PlxUtilities();
        $utility->json($status, $response);
    }

    public function oder_tracking(Request $request, $order_code = 1)
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'footer';
        $data['track_order'] = 'start active open';
        $data['track_order'] = 'active';


        $data['order_info'] = $order_info = Order::with(['order_details', 'lp_info', 'UdcCustomer'])
            ->where('user_id', Auth::user()->id)
            ->where('order_code', $order_code)
            ->first();

        if ($data['order_info']) {
            $data['tracking_details'] = OrderTrack::where('order_id', @$order_info->id)->get();
            if ($data['tracking_details']) {
                $data['maxstatus'] = $this->getMaxStatus($data['tracking_details']);
            }
            $data['status_tracking_info'] = OrderTrack::where('order_id', @$order_info->id)->get()->groupBy('status');
        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.udc.order-tracking-render', $data)->render());
        } else {
            return view('admin.udc.order-tracking')->with($data);
        }
    }

    function getMaxStatus($array)
    {
        $max = 0;
        foreach ($array as $k => $v) {
            $max = max(array($max, $v['status']));
        }
        return $max;
    }
    
    public function server_log($data, $file_name)
    {
        $log_filename = base_path('partner_save_API_log');
        if (!file_exists($log_filename)) {
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename . '/' . $file_name;
        file_put_contents($log_file_data, $data . "\n", FILE_APPEND);

    }
}

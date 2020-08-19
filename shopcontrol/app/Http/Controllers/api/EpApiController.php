<?php
/**
 * Created by PhpStorm.
 * User: Parallax PC-1
 * Date: 10/15/2017
 * Time: 3:07 PM
 */

namespace App\Http\Controllers\api;

use App\CartDetail;
use App\Libraries\EkomEncryption;
use App\Libraries\PlxUtilities;
use App\models\EcommercePartner;
use App\models\_ecom_Setting;
use App\models\EpSession;
use App\models\LogisticPartner;
use App\models\Order;
use App\models\OrderTrack;
use App\models\User;
use Carbon\Carbon;
use Cart;
use Auth;
use Validator;
use Illuminate\Http\Request;


class EpApiController
{
    public function set_cart(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        $utility = new PlxUtilities();

        $validator = Validator::make($request->all(), [
            'cart_detail' => 'required',
            'access_token' => 'required',
            'session_token' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            $utility->json($status, $response);
        } else {
            
            
            $epinfo = EcommercePartner::where('access_token', $request->access_token)->first();
            if ($epinfo) {
                $dc_ep_session_info = EpSession::where('ep_id', $epinfo->id)
                    ->where('session_token', $request->session_token)
                    ->first();

                if ($dc_ep_session_info) {
                    $cart_data = CartDetail::where('user_id', $dc_ep_session_info->user_id)->first();
                    if (!$cart_data) {
                        $cart_data = new CartDetail();
                    }

                    $total_commission = 0;
                    $total_price = 0;
                    $commission_flag = true;

                    $cart_detail = json_decode($request->cart_detail);
                    foreach ($cart_detail->cart as $each_product) {
                        if (isset($each_product->commission)) {
                            $total_commission += @$each_product->commission;
                        } else {
                            $commission_flag = false;
                            $total_price += @$each_product->price;
                        }
                    }

                    if ($commission_flag == false) {
                        $total_commission = ($total_price / 100) * 5;
                    }

                    $cart_data->ep_id = $epinfo->id;
                    $cart_data->cart_session_time = date('Y-m-d H:i:s');
                    $cart_data->user_id = $dc_ep_session_info->user_id; // HERE USER INFO IS DC INFO
                    $cart_data->cart_detail = json_encode($cart_detail);
                    $cart_data->order_commission = $total_commission;
                    
                    $cart_data->save();
                    
                   
                    $status = 200;
                    $response['message'] = 'Success';
                    $response['redirect_url'] = url('checkout-ep');
                } else {
                    $response['message'] = 'Session token hase been expired';
                }
            } else {
                $response['message'] = 'Authentication has Failed';
            }
        }
        $utility->json($status, $response);
    }
    
    public function server_log($data, $file_name)
    {

        $log_filename = base_path('custom_log_set_cart');
        if (!file_exists($log_filename)) {
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename . '/' . $file_name;
        file_put_contents($log_file_data, $data . "\n", FILE_APPEND);

    }

    public function create_ep_session(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        $utility = new PlxUtilities();
        if ($request->token_info === null) {
            $response['message'] = 'Token info is required';
        } else {
            $token_info = json_decode($request->token_info);

            $epinfo = EpSession::where('auth_token', $token_info->auth_token)->first();
            if ($epinfo) {
                $encrypter = new EkomEncryption($epinfo->ep_id);
                $epinfo->session_token = date('ydmHis') . $encrypter->encrypt();
                $epinfo->save();
                $status = 200;
                $response['message'] = 'Session created successfully';
                $response['session_token'] = $epinfo->session_token;
            } else {
                $response['message'] = 'Authentication has Failed';
            }
        }

        $utility->json($status, $response);
        exit();
    }

    public function change_order_status(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        $utility = new PlxUtilities();

        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'order_id' => "required",
            'status' => 'required|max:1|min:1',
            'message' => 'required_if:status,5|max:100'
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
        } else {

            $ep_info = EcommercePartner::where('access_token', $request->access_token)->first();

            if (@$ep_info) {

                $order_info = Order::where(function ($q) use ($request) {
                    $q->where('ep_order_id', $request->order_id);
                    $q->orWhere('order_code', $request->order_id);
                })->where('ep_id', @$ep_info->id)->first();

                if (@$order_info) {
                    $changable_code = array(2, 5);

                    $ecom_setting = _ecom_Setting::first();
                    $possible_order_time = Carbon::now()->subHour($ecom_setting->order_cancel_time);
                    if ($order_info->created_at < $possible_order_time) {

                        $response['message'] = 'You can cancel an order within ' . @$ecom_setting->order_cancel_time . ' hours after placing in your system.';

                    } else if (in_array($request->status, $changable_code) && $order_info->status == 1) {

                        $order_info->status = $request->status;
                        $order_info->save();

                        //SAVE TRACKING INFORMATION
                        if ($request->status == 2) {

                            $order_track = new OrderTrack();
                            $order_track->order_id = $order_info->id;
                            $order_track->status = $order_info->status;
                            $order_track->message_by = $ep_info->ep_name;
                            $order_track->message = "Order left EP warehouse";
                            $order_track->save();

                        } elseif ($request->status == 5) {

                            $order_track = new OrderTrack();
                            $order_track->order_id = $order_info->id;
                            $order_track->status = $request->status;
                            $order_track->message_by = $ep_info->ep_name;
                            $order_track->message = $request->message;
                            $order_track->save();

                        }

                        $status = 200;
                        $response['message'] = 'Status has been changed successfully.';

                    } else {

                        $response['message'] = 'You have no access to change order to your given status.';

                    }

                } else {
                    $response['message'] = 'Sorry wrong order code';
                }

            } else {
                $response['message'] = 'Sorry access token not matched.';
            }
        }
        $utility->json($status, $response);
    }

    public function orders(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        $utility = new PlxUtilities();


        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'from' => "required",
            'to' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
        } else {
            $ep_info = EcommercePartner::where('access_token', $request->access_token)->first();
            if ($ep_info) {
                $unsuccessful_orders = Order::with(['order_details'])
                    ->where('created_at', '>=', $request->from)
                    ->where('created_at', '<=', $request->to)
                    ->where('ep_order_id', null)
                    ->where('status', 1)
                    ->where('ep_id', $ep_info->id)
                    ->get();

                $orders = array();
                foreach($unsuccessful_orders as $order){
                    $ep_order = new \stdClass();
                    $ep_order->order_details = array();
                    $lp_info = LogisticPartner::find($order->lp_id);
                    $dc_info = User::find($order->user_id);

                    $ep_order->order_code = $order->order_code;
                    $ep_order->status = $order->status;
                    $ep_order->created_at = $order->created_at;

                    $ep_order->lp_code = $lp_info->lp_code;
                    $ep_order->lp_name = $order->lp_name;
                    $ep_order->lp_contact_person = $order->lp_contact_person;
                    $ep_order->lp_contact_number = $order->lp_contact_number;
                    $ep_order->lp_delivery_charge = $order->lp_delivery_charge;
                    $ep_order->lp_location = $order->lp_location;
                    $ep_order->delivery_duration = $order->delivery_duration;

                    $ep_order->recipient_center_name = $dc_info->center_name;
                    $ep_order->recipient_name = $order->receiver_name;
                    $ep_order->recipient_mobile = $order->receiver_contact_number;
                    $ep_order->recipient_email = $order->email;
                    $ep_order->recipient_division = $dc_info->division;
                    $ep_order->recipient_district = $dc_info->district;
                    $ep_order->recipient_upazila = $dc_info->upazila;
                    $ep_order->recipient_union = $dc_info->union;
                    $ep_order->payment_method = $order->payment_method;


                    foreach($order->order_details as $key=>$order_detail){

                        $ep_order->order_details[$key] = new \stdClass();
                        $ep_order->order_details[$key]->product_id = $order_detail->ep_product_id;
                        $ep_order->order_details[$key]->product_name = $order_detail->product_name;
                        $ep_order->order_details[$key]->product_url = $order_detail->product_url;
                        $ep_order->order_details[$key]->unit_price = $order_detail->unit_price;
                        $ep_order->order_details[$key]->quantity = $order_detail->quantity;
                        $ep_order->order_details[$key]->price = $order_detail->price;
                        $ep_order->order_details[$key]->purchase_commission = @$order_detail->purchase_commission;

                        $ep_order->order_details[$key]->variation_id = @$order_detail->variation_id;
                        $ep_order->order_details[$key]->option = @$order_detail->option;

                    }

                    $ep_order->cart_options = new \stdClass();
                    $ep_order->cart_options->cart_id = @$order_detail->ep_cart_id?@$order_detail->ep_cart_id:'';

                    $orders[] = $ep_order;
                }

                $response['orders'] = $orders;
                $status = 200;
                $response['message'] = count($response['orders']) . " orders found from date " . $request->from . " to " . $request->to . ".";
            } else {
                $response['message'] = "Access token not matched.";
            }
        }

        $utility->json($status, $response);
        exit();
    }

}
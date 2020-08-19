<?php

namespace App\Http\Controllers\api;

use App\models\EcommercePartner;
use App\models\LogisticPartner;
use App\models\Order;
use App\models\OrderTrack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Libraries\PlxUtilities;

class LpApiController extends Controller
{
    public $order_status = array("1" => "active", "2" => "warehouse left", "3" => "on delivery", "4" => "delivered", "5" => "cancel");

    public function change_order_status(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        $utility = new PlxUtilities();

        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'order_code' => 'required',
            'status' => 'required|max:1|min:1',
            'message' => 'max:255',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
        } else {
            $lp_info = LogisticPartner::where('access_token', $request->access_token)->first();

            if ($lp_info) {

                $order_info = Order::where('order_code', $request->order_code)->where('lp_id', $lp_info->id)->first();

                if ($order_info) {

                    $changeable_code = array(3);

                    if (!in_array($request->status, $changeable_code)) {

                        $response['message'] = 'You have no access to change order status to ' . $this->order_status[$request->status] . '.';

                    } else {
                        if ($order_info->status == 2) {


                            $order_info->status = $request->status;
                            $order_info->save();
                            $status = 200;
                            $response['message'] = 'Order status has bean changed successfully.';

                            $order_track = new OrderTrack();
                            $order_track->order_id = $order_info->id;
                            $order_track->status = 3;
                            $order_track->message_by = $lp_info->lp_name;
                            $order_track->message = "Order on delivery";
                            $order_track->save();


                        } else {

                            $status_message = array(
                                "1" => "This order is not left the warehouse yet, please try after EP update this order",
                                "4" => "The order already delivered",
                                "5" => "The order has been canceled"
                            );
                            $response['message'] = 'You have no access to change order status.' . $status_message[$order_info->status];

                        }
                    }

                } else {
                    $response['message'] = 'Order not found.';
                }

            } else {
                $response['message'] = 'Sorry access token not matched.';
            }
        }
        $utility->json($status, $response);
    }

    public function save_order_tracking_message(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        $utility = new PlxUtilities();

        $validator = Validator::make($request->all(), [
            'access_token' => 'required',
            'order_code' => 'required',
            'message' => 'required|max:100',
            'status' => '',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
        } else {
            $lp_info = LogisticPartner::where('access_token', $request->access_token)->first();

            if ($lp_info) {

                $order_info = Order::where('order_code', $request->order_code)->where('lp_id', $lp_info->id)->first();
                if ($order_info) {

                    if ($order_info->status > 1 && $order_info->status < 5) {

                        //SAVE TRACKING INFORMATION
                        $order_track = new OrderTrack();
                        $order_track->order_id = $order_info->id;
                        $order_track->status = $order_info->status;
                        $order_track->message_by = $lp_info->lp_name;
                        $order_track->message = $request->message;
                        $order_track->save();
                        $status = 200;
                        $response['message'] = 'Order tracking message has bean saved successfully.';

                    } else {
                        $response['message'] = 'This order is not left warehouse yet, please try after EP update this order';
                    }

                } else {
                    $response['message'] = 'Order not found.';
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
            $lp_info = LogisticPartner::where('access_token', $request->access_token)->first();
            if ($lp_info) {

                $unsuccessful_orders = Order::with(['order_details'])
                    ->where('created_at', '>=', $request->from)
                    ->where('created_at', '<=', $request->to)
                    ->where('lp_order_id', null)
                    ->where('status', 1)
                    ->where('lp_id', $lp_info->id)
                    ->get();

                $orders = array();

                foreach($unsuccessful_orders as $order){
                    $lp_order = new \stdClass();
                    $lp_order->order_details = array();
                    $ep_info = EcommercePartner::find($order->ep_id);
                    $dc_info = User::find($order->user_id);

                    $lp_order->order_code = $order->order_code;
                    $lp_order->status = $order->status;
                    $lp_order->created_at = $order->created_at;

                    $lp_order->lp_code = $lp_info->lp_code;
                    $lp_order->lp_name = $order->lp_name;
                    $lp_order->lp_contact_person = $order->lp_contact_person;
                    $lp_order->lp_contact_number = $order->lp_contact_number;
                    $lp_order->lp_delivery_charge = $order->lp_delivery_charge;
                    $lp_order->lp_location = $order->lp_location;
                    $lp_order->delivery_duration = $order->delivery_duration;

                    $lp_order->recipient_center_name = $dc_info->center_name;
                    $lp_order->recipient_name = $order->receiver_name;
                    $lp_order->recipient_mobile = $order->receiver_contact_number;
                    $lp_order->recipient_email = $order->email;
                    $lp_order->recipient_division = $dc_info->division;
                    $lp_order->recipient_district = $dc_info->district;
                    $lp_order->recipient_upazila = $dc_info->upazila;
                    $lp_order->recipient_union = $dc_info->union;
                    $lp_order->payment_method = $order->payment_method;


                    foreach($order->order_details as $key=>$order_detail){

                        $lp_order->order_details[$key] = new \stdClass();
                        $lp_order->order_details[$key]->product_id = $order_detail->ep_product_id;
                        $lp_order->order_details[$key]->product_name = $order_detail->product_name;
                        $lp_order->order_details[$key]->product_url = $order_detail->product_url;
                        $lp_order->order_details[$key]->unit_price = $order_detail->unit_price;
                        $lp_order->order_details[$key]->quantity = $order_detail->quantity;
                        $lp_order->order_details[$key]->price = $order_detail->price;
                        $lp_order->order_details[$key]->purchase_commission = @$order_detail->purchase_commission;

                        $lp_order->order_details[$key]->variation_id = @$order_detail->variation_id;
                        $lp_order->order_details[$key]->option = @$order_detail->option;

                    }

                    $orders[] = $lp_order;
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

<?php

namespace App\Http\Controllers\bpo\bpoapi;

use App\Libraries\PlxUtilities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\LogisticPartner;
use App\models\Order;
use App\models\OrderTrack;
use Validator;

class BpoApiController extends Controller
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
                                "2" => "The order is not left the warehouse yet.",
                                "3" => "The order already on the way",
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
}
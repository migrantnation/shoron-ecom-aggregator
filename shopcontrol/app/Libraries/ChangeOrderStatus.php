<?php
/**
 * Created by PhpStorm.
 * User: Parallax PC-1
 * Date: 1/3/2018
 * Time: 3:38 PM
 */

namespace App\Libraries;


use App\models\Order;
use App\models\OrderTrack;
use Illuminate\Support\Facades\Auth;

class ChangeOrderStatus
{
    private $payment_status = array(
        '1' => 'COD',
        '2' => 'Online Payment',
        '3' => 'Payment Complete'
    );

    private $payment_status_class = array(
        "0" => "primary",
        "1" => "primary",
        "2" => "warning",
        "3" => "info",
        "4" => "success",
        "5" => "danger"
    );

    public function change_order_status($order_code)
    {
        //Change Order Status
        $order_info = Order::where('order_code', $order_code)->first();
        $order_info->status = 4;
        $order_info->payment_status = 3;
        $order_info->save();
        $this->tracking_message($order_info, 4, Auth::user()->name_bn);
    }

    private $status_message = array(
        "Order Placed",
        "Preparation Completed",
        "Warehouse Left from ",
        "Order on the way",
        "Order delivered"
    );

    public function tracking_message($order_info, $status, $message_by)
    {
        $order_track = new OrderTrack();
        $order_track->order_id = $order_info->id;
        $order_track->status = $order_info->status;
        $order_track->message_by = $message_by;
        $order_track->message = $this->status_message[$status];
        $order_track->save();
    }

    public function get_payment_status($status)
    {
        return $this->payment_status[$status];
    }

    public function get_payment_status_class($status)
    {
        return $this->payment_status_class[$status];
    }
}
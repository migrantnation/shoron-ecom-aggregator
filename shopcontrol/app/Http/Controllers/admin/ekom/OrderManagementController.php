<?php

namespace App\Http\Controllers\admin\ekom;
use App\Libraries\PlxUtilities;
use App\models\Order;
use App\models\OrderTrack;
use App\models\EcommercePartner;
use App\models\LogisticPartner;
use App\models\UdcCustomer;
use App\models\User;
use App\Http\Traits\SMSTraits;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class OrderManagementController extends Controller
{

        use SMSTraits;

    public function order_details_previous($order_id)
    {
        $data = array();
        $data['side_bar'] = 'udc_side_bar';
        $data['header'] = 'udc_header';
        $data['footer'] = 'udc_footer';
        $data['purchases'] = 'start active open';
        $data['purchase'] = 'active';

        $data['order_info'] = Order::with(['order_details', 'order_invoice', 'lp_info', 'UdcCustomer'])->where('id', $order_id)->first();

        $data['user_info'] = $user_info = User::find($data['order_info']->user_id);
        if ($data['order_info']) {
            $data['udcCustomers'] = UdcCustomer::where('udc_id', $data['order_info']->user_id)->get();
            return view('admin.udc.order-details')->with($data);
        } else {
            return redirect('');
        }
    }


    public function order_details($order_id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['udc_management'] = 'start active open';
        $data['all_udc'] = 'active';

        $data['order_info'] = Order::with(['order_details', 'order_invoice', 'lp_info', 'UdcCustomer'])->where('id', $order_id)->first();
        $data['user_info'] = $user_info = User::find(@$data['order_info']->user_id);
        $data['tracking_details'] = OrderTrack::where('order_id', $order_id)->get();
        $data['status_tracking_info'] = OrderTrack::where('order_id', $order_id)->get()->groupBy('status');


        if ($data['tracking_details']) {
            $data['maxstatus'] = $this->getMaxStatus($data['tracking_details']);
        }

        if ($data['order_info']) {
            $data['udcCustomers'] = UdcCustomer::where('udc_id', $data['order_info']->user_id)->get();
            return view('admin.ekom.udc.order-details')->with($data);
        } else {
            return redirect('');
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

            $admin_info = Auth::guard('web_admin')->user();

            if ($admin_info) {

                $changable_code = array(2, 3, 4, 5);

                if (!in_array($request->status, $changable_code)) {
                    $response['message'] = 'You have no access to change order status.';
                } else {
                    $order_code = $request->order_code;
                    $data["order_info"] = $order_info = Order::where('order_code', $order_code)->first();

                    if ($order_info) {

                        if ($request->status < 5 && $order_info->status > 0) {

                            // SAVE ORDER CANCEL MESSAGE
                            $order_track = new OrderTrack();
                            $order_track->order_id = $order_info->id;
                            $order_track->status = $request->status;
                            $order_track->message_by = "_ecom_ Admin:" . Auth::guard('web_admin')->user()->name;
                            $order_track->user_type = "_ecom_ Admin";
                            $order_track->message = $request->message;
                            $order_track->save();

                        } else if ($request->status == 2) {

                            $order_track = new OrderTrack();
                            $order_track->order_id = $order_info->id;
                            $order_track->status = $request->status;
                            $order_track->message_by = "_ecom_ Admin";
                            $order_track->user_type = "_ecom_ Admin";
                            $order_track->message = "Warehouse Left";
                            $order_track->save();

                        } else if ($request->status == 3) {

                            if ($order_info->status == 1) {
                                $order_track = new OrderTrack();
                                $order_track->order_id = $order_info->id;
                                $order_track->status = 2;
                                $order_track->message_by = "_ecom_ Admin";
                                $order_track->user_type = "_ecom_ Admin";
                                $order_track->message = "Warehouse Left";
                                $order_track->save();
                            }

                            $order_track = new OrderTrack();
                            $order_track->order_id = $order_info->id;
                            $order_track->status = $request->status;
                            $order_track->message_by = "_ecom_ Admin";
                            $order_track->user_type = "_ecom_ Admin";
                            $order_track->message = "Order on the way";
                            $order_track->save();

                        } else if ($request->status == 4) {

                            if ($order_info->status == 2) {

                                $order_track = new OrderTrack();
                                $order_track->order_id = $order_info->id;
                                $order_track->status = 2;
                                $order_track->message_by = '_ecom_ Admin';
                                $order_track->user_type = "_ecom_ Admin";
                                $order_track->message = "No information get from EP";
                                $order_track->save();

                                $order_track = new OrderTrack();
                                $order_track->order_id = $order_info->id;
                                $order_track->status = 3;
                                $order_track->message_by = '_ecom_ Admin';
                                $order_track->user_type = "_ecom_ Admin";
                                $order_track->message = "No information get from LP";
                                $order_track->save();

                            } elseif ($order_info->status == 3) {

                                $order_track = new OrderTrack();
                                $order_track->order_id = $order_info->id;
                                $order_track->status = 3;
                                $order_track->message_by = '_ecom_ Admin';
                                $order_track->user_type = "_ecom_ Admin";
                                $order_track->message = "No information get from LP";
                                $order_track->save();

                            }

                            $order_track = new OrderTrack();
                            $order_track->order_id = $order_info->id;
                            $order_track->status = $request->status;
                            $order_track->message_by = '_ecom_ Admin';
                            $order_track->user_type = "_ecom_ Admin";
                            $order_track->message = "Order received by DC";
                            $order_track->save();

                            //UPDATE PAYMENT STATUS
                            $order_info->payment_status = 3;
                        }

                        $order_info->status = $request->status;
                        $order_info->save();
                        
                        if($request->status == 5){
                            //SMS
                            $user_info = User::find($order_info->user_id);
                            $ep_info = EcommercePartner::find($order_info->ep_id);
                            $lp_info = LogisticPartner::find($order_info->lp_id);

                            $sending_to = array('UDC','EP','LP');

                            foreach ($sending_to as $value){
                                $sendsms = $this->sendsms($order_info, $user_info,$ep_info,$lp_info, $value, 5);
                            }
                        }

                        $status = 200;
                        $response['message'] = 'Order status has bean changed successfully.';

                    } else {
                        $response['message'] = 'Order not found.';
                    }
                }
            } else {
                $status = 101;
                $response['message'] = 'Something went wrong please contact with technical support team.';
            }
        }

        $utility = new PlxUtilities();
        $utility->json($status, $response);
    }

    public function oder_tracking(Request $request, $order_code = 1)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['order_management'] = 'start active open';
        $data['track_order'] = 'active';

        $data['order_info'] = $order_info = Order::with(['order_details', 'lp_info', 'UdcCustomer', 'user'])
            ->where('order_code', $order_code)
            ->first();

        $data['tracking_details'] = OrderTrack::where('order_id', @$order_info->id)->get();
        $data['status_tracking_info'] = OrderTrack::where('order_id', @$order_info->id)->get()->groupBy('status');

        if ($data['tracking_details']) {
            $data['maxstatus'] = $this->getMaxStatus($data['tracking_details']);
        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.orders.render-order-tracking', $data)->render());
        } else {
            return view('admin.ekom.orders.order-tracking')->with($data);
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

    function get_order_log(Request $request)
    {
        $status = 100;
        $response = array();
        $response['message'] = '';
        $utility = new PlxUtilities();

        $validator = Validator::make($request->all(), [
            'order_code' => 'required',
        ]);
        if ($validator->fails()) {

            $response['message'] = $validator->errors()->first();
            $utility->json($status, $response);

        } else {
            $get_log_info = Order::where('order_code', $request->order_code)->first();
            if ($request->field == 'ep_log') {
                $file_path = base_path('custom_log/' . $get_log_info->ep_log);
            } else if ($request->field == 'lp_log') {
                $file_path = base_path('custom_log/' . $get_log_info->lp_log);
            }
            if (is_file($file_path)) {
                $get_log = file_get_contents($file_path);
                $status = 200;
                $response['view'] = $get_log;
            } else {
                $response['message'] = "File not Found";
            }

        }
        $utility->json($status, $response);
    }

}

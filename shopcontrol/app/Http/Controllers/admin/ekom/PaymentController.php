<?php

namespace App\Http\Controllers\admin\ekom;

use App\Http\Middleware\AdminAuth;
use App\Libraries\PlxUtilities;
use App\models\EcommercePartner;
use App\models\EpPayment;
use App\models\LpPayment;
use App\models\Order;
use App\models\UdcPayment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public $row_per_page = 10;

    public function index()
    {
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['payments'] = 'start active open';
        $data['ep_orders'] = 'active';
        $data['ep_list'] = EcommercePartner::all();
        return view('admin.ekom.payments.index')->with($data);
    }

    public function make_payment_to_ep($id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['payments'] = 'start active';

        $data['udc_info'] = Udc::find($id);
        if ($data['udc_info']) {
            return view('admin.ekom.udc.udc_profile')->with($data);
        } else {
            return redirect('admin/udc');
        }
    }

    public function ep_orders(Request $request, $ep_id)
    {
        $data = array();
        $data['side_bar'] = 'ekom_side_bar';
        $data['header'] = 'header';
        $data['footer'] = 'footer';
        $data['payments'] = 'start active open';
        $data['ep_orders'] = 'active';
        $data['ep_id'] = $ep_id;
        $data['ep_info'] = EcommercePartner::find($ep_id);


        $data['total_order_value'] = DB::table('orders')
            ->selectRaw('sum(total_price + ep_commission - ekom_commission - udc_commission) as total_order_value')
            ->where('ep_id', $ep_id)
            ->where('status', '=', 4)
            ->groupBy('status')
            ->first();

        $data['total_due'] = DB::table('orders')
            ->selectRaw('sum(total_price + ep_commission - ekom_commission - udc_commission) as total_due')
            ->where('ep_id', $ep_id)
            ->where('status', '=', 4)
            ->where('payment_disburse_status', '=', 0)
            ->groupBy('status')
            ->first();

        $input = $request->all();
        if (isset($input['search_string'])) {
            $util = new PlxUtilities();
//            $sstring = $input['search_string'];
            $sstring = $util->bn2enNumber($input['search_string']);
            $data['all_orders'] = Order::where(function ($query) use ($request, $ep_id) {
                $query->where('status', '=', 4)->where('payment_disburse_status', 0)->where('ep_id', $ep_id);
            })->where(function ($query) use ($request) {
                $query->where('order_code', 'LIKE', '%' . $request->search_string . '%');
            })->orderBy('id', 'desc')->paginate($this->row_per_page)->withPath("?search_string=$sstring");

        } else {
            $data['all_orders'] = Order::where('status', '=', 4)->where('payment_disburse_status', 0)->where('ep_id', $ep_id)->orderBy('id', 'desc')->paginate($this->row_per_page);
        }

        if ($request->ajax()) {
            return Response::json(View::make('admin.ekom.payments.render-ep-orders', array('all_orders' => $data['all_orders'], 'total_order_value' => $data['total_order_value'], 'total_due' => $data['total_due'], 'ep_info' => $data['ep_info']))->render());
        } else {
            return view('admin.ekom.payments.ep-orders')->with($data);
        }
    }

    public function pay_to_ep(Request $request)
    {
        $input = $request->all();
        $rules = array('order_ids' => 'required');
        $messages = ['order_ids.required' => 'Please select at least one order from below order list to make a payment.'];
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $order_ids = implode(',', $request->order_ids);

            $get_orders = Order::whereRaw("FIND_IN_SET(id, '$order_ids')")->get();
            $ep_amount = Order::whereRaw("FIND_IN_SET(id, '$order_ids')")->sum(DB::raw('total_price + ep_commission  - ekom_commission - udc_commission'));

//            dd($ep_amount);
            //CREATE PAYMENT
            $transaction_number = rand(111111, 9999999);

            Order::whereRaw("FIND_IN_SET(id, '$order_ids')")->update(['payment_disburse_status' => 1]);

            //EP PAYMENT
            $ep_payment_data = new EpPayment();
            $ep_payment_data->transaction_number = $transaction_number;
            $ep_payment_data->order_ids = $order_ids;
            $ep_payment_data->amount = $ep_amount;
            $ep_payment_data->created_by = Auth::guard('web_admin')->user()->id;
            $ep_payment_data->save();

            // UDC PAYMENT
            foreach ($get_orders as $each_order) {
                if ($each_order->udc_commission > 0) {
                    $udc_payment_data = new UdcPayment();
                    $udc_payment_data->transaction_number = $transaction_number;
                    $udc_payment_data->order_code = $each_order->order_code;
                    $udc_payment_data->order_id = $each_order->id;
                    $udc_payment_data->udc_id = $each_order->user_id;
                    $udc_payment_data->amount = $each_order->udc_commission;
                    $udc_payment_data->created_by = Auth::guard('web_admin')->user()->id;
                    $udc_payment_data->save();
                }
            }

            return back()->with('message', App::isLocale('bn') ? 'পেমেন্ট সফলভাবে প্রদান করা হয়েছে' : 'Payment Has Been Disbursed Successfully!');
        }
    }
}
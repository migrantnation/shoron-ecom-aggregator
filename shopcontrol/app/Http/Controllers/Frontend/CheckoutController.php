<?php

namespace App\Http\Controllers\Frontend;

use App\CartDetail;
use App\Libraries\PlxUtilities;
use App\models\EcommercePartner;
use App\models\LogisticPartner;
use App\models\CountryLocation;
use App\models\LpShippingPackage;
use App\models\Order;
use App\models\Store;
use App\models\Udc;
use App\models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function checkout1()
    {
        $util = new PlxUtilities();
        $util->check_cart_session_time();
        $data = array();

        //DC INFORMATION
        $data['user_info'] = $user_info = Auth::user();

        // CART INFORMATION
        $data['cart_details'] = $cart_details = CartDetail::where('user_id', Auth::user()->id)->first();
        if ($cart_details) {
            $cart_detail = json_decode($cart_details->cart_detail);
            if (!$cart_detail || !$cart_details->ep_id) {
                return redirect('');
            }
        } else {
            return redirect('');
        }



        if ($cart_details->lp_id) {
            $data['lp_info'] = LogisticPartner::find($cart_details->lp_id);
        }

        $data['ep_info'] = $ep_info = EcommercePartner::find($cart_details->ep_id);

//        $rest = LogisticPartner::where('status', 1)
//            ->whereIn('id', explode(',',$ep_info->selected_lp_ids))
//            ->whereHas('packages', function ($q) use ($ep_info, $user_info) {
//
//                $q->where(function ($q) use ($user_info) {
//                    $q->where('location_id', $user_info->id)->orWhere('location_id', 0);
//                })->where('is_selected', 1)->orderBy('lp_id', 'asc');
//
//            })->with(['packages' => function ($q) use ($user_info) {
//
//                $q->where(function ($q) use ($user_info) {
//                    $q->where('location_id', $user_info->id)->orWhere('location_id', 0);
//                })->where('is_selected', 1)->orderBy('lp_id', 'asc');
//
//            }])->get();

//        dd($rest);


        $rest = LpShippingPackage::whereHas('logistic_partner', function($q){
				$q->where('status', 1);
			})->with(['logistic_partner'=>function($q){
				$q->where('status', 1);
			}])->where('location_id', $user_info->id)
			->where('is_selected', 1)
			->orderBy('lp_id', 'asc')->get();


        $data['lp_packages'] = json_encode($rest);
        $data['selected_lps'] =session()->get('logistic_partner');
        $data['baseurl']=url('/');
        $data['csrf_v_token']=csrf_token();
        $data['lang_val']=Session::get('lang');


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'http://198.54.123.222/plxhome/_ecom__sec/api/checkout');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        return $server_output;


        $data['lps'] = json_decode($data['lp_packages']);
        $data['cart_details'] = json_decode($data['cart_details']);
        $data['user_info'] = json_decode($data['user_info']);
//        $data['lp_info'] = json_decode($data['lp_info']);
        $data['ep_info'] = json_decode($data['ep_info']);
        $data['csrf_v_token'] = ($data['csrf_v_token']);
        $data['lang_val'] = ($data['lang_val']);

        return view('frontend.checkout.checkout_ep')->with($data);
    }

    public function checkout()
    {
        $util = new PlxUtilities();
        $util->check_cart_session_time();
        $data = array();

        //DC INFORMATION
        $data['user_info'] = $user_info = Auth::user();

        // CART INFORMATION
        $data['cart_details'] = $cart_details = CartDetail::where('user_id', Auth::user()->id)->first();
        if ($cart_details) {
            $cart_detail = json_decode($cart_details->cart_detail);
            if (!$cart_detail || !$cart_details->ep_id) {
                return redirect('');
            }
        } else {
            return redirect('');
        }


        if ($cart_details->lp_id) {
            $data['lp_info'] = LogisticPartner::find($cart_details->lp_id);
        }

        $data['ep_info'] = $ep_info = EcommercePartner::find($cart_details->ep_id);

        $rest = LogisticPartner::where('status', 1)
            ->whereIn('id', explode(',',$ep_info->selected_lp_ids))
            ->whereHas('packages', function ($q) use ($ep_info, $user_info) {

                $q->where(function ($q) use ($user_info) {
                    $q->where('location_id', $user_info->id)->orWhere('location_id', 0);
                })->where('is_selected', 1)->orderBy('lp_id', 'asc');

            })->with(['packages' => function ($q) use ($user_info) {

                $q->where(function ($q) use ($user_info) {
                    $q->where('location_id', $user_info->id)->orWhere('location_id', 0);
                })->where('is_selected', 1)->orderBy('lp_id', 'asc');

            }])->get();

//        dd($rest);

        $data['lp_packages'] = json_encode($rest);
        $data['selected_lps'] = session()->get('logistic_partner');
        $data['baseurl'] = url('/');
        $data['csrf_v_token'] = csrf_token();
        $data['lang_val'] = Session::get('lang');

//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, 'http://198.54.123.222/plxhome/_ecom__sec/api/checkout');
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $server_output = curl_exec($ch);
//        curl_close($ch);
//        return $server_output;


        $data['lps'] = json_decode($data['lp_packages']);
        $data['cart_details'] = json_decode($data['cart_details']);
        $data['user_info'] = json_decode($data['user_info']);
//        $data['lp_info'] = json_decode($data['lp_info']);
        $data['ep_info'] = json_decode($data['ep_info']);
        $data['csrf_v_token'] = ($data['csrf_v_token']);
        $data['lang_val'] = ($data['lang_val']);

        return view('frontend.checkout.checkout_ep')->with($data);
    }


    public function select_lp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lp_package_id' => 'required'
        ],[
            'lp_package_id.required' => 'Logistic partner package is required'
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $data['user_info'] = $user_info = Auth::user();
            $data['cart_details'] = $cart_details = CartDetail::where('user_id', Auth::user()->id)->first();

            if ($cart_details) {

                $package_info = LpShippingPackage::with(['logistic_partner'])->where('id', $request->lp_package_id)->first();
                $lp_info = $package_info->logistic_partner;

                $cart_details->lp_id = $package_info->lp_id;
                $cart_details->lp_package_id = $package_info->id;
                $cart_details->lp_name = $package_info->logistic_partner->lp_name;
                $cart_details->lp_contact_person = $package_info->logistic_partner->contact_person;
                $cart_details->lp_contact_number = $package_info->logistic_partner->contact_number;
                $cart_details->lp_delivery_charge = $package_info->price;

                $address[] = @$user_info->center_name;
                if (@$user_info->union)
                    $address[] = 'ইউনিয়ন: ' . @$user_info->union;
                if (@$user_info->upazila)
                    $address[] = 'উপজেলা: ' . @$user_info->upazila;
                if (@$user_info->district)
                    $address[] = 'জেলা: ' . @$user_info->district;
                if (@$user_info->division)
                    $address[] = 'বিভাগ: ' . @$user_info->division;
                $center_address = implode(', ', $address);

                $cart_details->delivery_location = $center_address;
                $cart_details->lp_location = $lp_info->address;
                $cart_details->delivery_duration = $package_info->delivery_duration;
                $cart_details->receiver_name = $user_info->name_bn;
                $cart_details->receiver_contact_number = $user_info->contact_number;

                $cart_details->update();

                return redirect('checkout-step-2');
            } else {
                return redirect()->back();
            }
        }
    }

    public function checkout_step_2()
    {
        $util = new PlxUtilities();
        $util->check_cart_session_time();
        $data = array();
        $data['user_info'] = $user_info = Auth::user();
        $data['cart_details'] = $cart_details = CartDetail::where('user_id', Auth::user()->id)->first();
        if (!$cart_details) {
            return redirect('');
        }

        if (!$cart_details->lp_id)
            return redirect('checkout-ep');

        $data['lp_info'] = LogisticPartner::find($cart_details->lp_id);
        $data['ep_info'] = EcommercePartner::find($cart_details->ep_id);

        return view('frontend.checkout.checkout_ep_step_2')->with($data);
    }

    public function send_otc(Request $request)
    {
        $data = array();

        $data['user_info'] = $user_info = Auth::user();

        $user_info->otc = rand(111111, 999999);
        $datetime = new Carbon();
        $datetime->addHours(6);
        $user_info->otc_time_limit = $datetime->parse();
        $user_info->update();

        $payment_methods = array('1');
        $data['cart_details'] = $cart_details = CartDetail::where('user_id', Auth::user()->id)->first();

        if(in_array($request->payment_method, $payment_methods)){
            $cart_details->payment_method = $request->payment_method;
            $cart_details->save();

            return redirect('place-order');
//            return redirect('checkout-step-3');
        }else{
            return redirect('checkout-step-2')->with('payment-method-exception', 'Please select a payment method.');
        }
    }

    public function checkout_step_3()
    {
        $util = new PlxUtilities();
        $util->check_cart_session_time();
        $data = array();
        $data['user_info'] = $user_info = Auth::user();
        $data['cart_details'] = $cart_details = CartDetail::where('user_id', Auth::user()->id)->first();
        if (!$cart_details) {
            return redirect('');
        }
        return view('frontend.checkout.checkout_ep_step_3')->with($data);
    }


    public function confirm_otc(Request $request)
    {
        $data = array();

        $data['user_info'] = $user_info = Auth::user();

        $data['cart_details'] = $cart_details = CartDetail::where('user_id', Auth::user()->id)->first();
        if (!$cart_details) {
            return redirect('');
        }

        $validator = Validator::make($request->all(), [
            'otc' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $otc_status = User::where('otc', $request->otc)
                ->where('id', $user_info->id)
                ->select('id', 'otc', 'otc_time_limit')
                ->first();

            if (!$otc_status) {
                return redirect('checkout-step-2');
            } else if (@$otc_status->otc_time_limit < date("Y-m-d H:i:s")) {
                $cart_details->two_fa_status = 1;
                $cart_details->update();

                $otc_status->otc = '';
                $otc_status->otc_time_limit = null;
                $otc_status->update();

                return redirect('place-order');
            } else {
                return redirect('checkout-step-2');
            }
        }
    }

    public function thanks_b2b()
    {
        $data = array();
        $data['order_details'] = Order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first();
        return view('frontend.checkout.thanks_b2b')->with($data);
    }

    public function thanks_b2c()
    {
        return view('frontend.checkout.thanks_b2c');
    }

}

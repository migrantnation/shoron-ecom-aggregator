<?php

namespace App\Http\Controllers\Frontend;

use App\CartDetail;
use App\Libraries\PlxUtilities;
use App\models\EcommercePartner;
use App\models\Product;
use App\models\ProductAttribute;
use App\models\ProductDetail;
use Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    public function cart()
    {
        $util = new PlxUtilities();
        $util->check_cart_session_time();

        $data = array();
        $data['cart_info'] = $cart_info = CartDetail::where('user_id', Auth::user()->id)->first();

        if (@$cart_info->cart_detail) {
            $data['ep_info'] = EcommercePartner::where('id', $cart_info->ep_id)->first();
            $data['cart_content'] = json_decode($cart_info->cart_detail)->cart;
            return view('frontend.cart.cart')->with($data);
        } else {
            return redirect('');
        }
    }


    public function remove_cart(Request $request)
    {
        $get_cart = CartDetail::where('user_id', Auth::user()->id)->first();
        $get_cart->cart_detail = '';
        $get_cart->save();
        return redirect('');
    }
}

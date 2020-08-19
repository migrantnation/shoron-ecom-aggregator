<?php

namespace App\Http\Controllers\Frontend;

use App\models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{

    public function stores()
    {
        $data = array();
        $data['featured_stores'] = Store::get();
        $data['stores'] = Store::with(['ecommerce_partner', 'udc', 'locations'])->get();

        return view('frontend.store.stores')->with($data);
    }

    public function store($store_url)
    {
        $data = array();

        $data['store_info'] = $store_info = Store::with(['ecommerce_partner', 'udc', 'locations'])->where('store_url', '=', $store_url)->first();

        $data['products'] = DB::table("products as p")->where('store_id', '=', $store_info->id)->get();
        $data['premium_related_products'] = DB::table("products as p")->where('store_id', '=', $store_info->id)->get();

        foreach ($data['products'] as $p_value) {
            $p_value->product_attributes = DB::table('product_attributes')->where('product_id', '=', $p_value->id)->get();
            $p_value->product_attribute_values = DB::table('product_attribute_values')->where('product_id', '=', $p_value->id)->get();
            $p_value->product_statistics = DB::table('product_statistics')->where('product_id', '=', $p_value->id)->get();
        }

        return view('frontend.store.store')->with($data);
    }

}

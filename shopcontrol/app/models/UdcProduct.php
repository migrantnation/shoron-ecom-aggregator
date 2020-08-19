<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UdcProduct extends Model
{
    protected $fillable = ['udc_id', 'price', 'product_name', 'product_image', 'description', 'seller_id'];

    public function get_product_details(){
        return $this->hasMany('App\models\UdcProductDetail', 'product_id', 'id')->with('get_ep');
    }

    public function get_seller(){
        return $this->hasOne('App\models\ProductSeller', 'id', 'seller_id');
    }
}
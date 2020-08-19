<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{

    public function order_with_buyer(){
        return $this->belongsTo('App\models\Order', 'order_id')->with(['user']);
    }

    public function order(){
        return $this->belongsTo('App\models\Order', 'order_id');
    }

    public function udc_product_info(){
        return $this->belongsTo('App\models\UdcProduct', 'udc_product_id');
    }

    public function udc_product_detail(){
        return $this->belongsTo('App\models\UdcProductDetail', 'udc_product_id', 'product_id');
    }

    public function buyer_info(){
        return $this->belongsTo('App\models\User', 'user_id');
    }

}

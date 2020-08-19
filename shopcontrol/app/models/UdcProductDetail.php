<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UdcProductDetail extends Model
{
    protected $fillable = ['ep_id','product_id','sku','permalink','product_url','quantity'];
    public function get_ep(){
        return $this->belongsTo('App\models\EcommercePartner','ep_id','id');
    }

    public function udc_product(){
        return $this->belongsTo('App\models\UdcProduct', 'product_id');
    }

}
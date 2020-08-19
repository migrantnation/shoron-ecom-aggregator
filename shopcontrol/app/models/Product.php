<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function product_attributes()
    {
        return $this->hasMany('App\models\ProductAttribute');
    }

    public function store()
    {
        return $this->hasOne('App\models\Store', 'id', 'store_id');
    }

    public function order()
    {
        return $this->hasMany('App\models\OrderDetail', 'product_id', 'id');
    }

    public function statistics()
    {
        return $this->hasOne('App\models\ProductStatistic', 'product_id', 'id');
    }

    public function product_details()
    {
        return $this->hasMany('App\models\ProductDetail');
    }
}

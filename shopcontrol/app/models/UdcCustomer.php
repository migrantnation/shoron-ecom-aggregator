<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UdcCustomer extends Model
{
    protected $fillable = ['customer_name','udc_id','customer_address','customer_contact_number'];

    public function order() {
        return $this->hasMany('App\models\Order', 'customer_id');
    }
}
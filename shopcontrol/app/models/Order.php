<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['status'];

    public function order_details()
    {
        return $this->hasMany('App\models\OrderDetail', 'order_id', 'id');
    }

    public function order_invoice()
    {
        return $this->hasOne('App\models\OrderInvoice', 'order_id');
    }

public function orders()
    {
        return $this->hasOne('App\models\User', 'id', 'user_id');
    }

    public function order_tracks()
    {
        return $this->hasOne('App\models\OrderTrack', 'order_id');
    }
    
    public function customer()
    {
        return $this->hasOne('App\models\User', 'id', 'buyer_id');
    }

    public function udc_customer()
    {
        return $this->hasOne('App\models\UdcCustomer', 'id', 'customer_id');
    }

    public function UdcCustomer()
    {
        return $this->belongsTo('App\models\UdcCustomer', 'customer_id');
    }

    public function ep_info()
    {
        return $this->hasOne('App\models\EcommercePartner', 'id', 'ep_id');
    }

    public function lp_info()
    {
        return $this->hasOne('App\models\LogisticPartner', 'id', 'lp_id');
    }

    public function user()
    {
        return $this->belongsTo('App\models\User');
    }
}
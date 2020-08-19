<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EcommercePartner extends Authenticatable
{

    //hidden attributes
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $fillable = [
        'access_token',
        'ep_name',
        'ep_short_code',
        'ep_code',
        'ep_logo',
        'email',
        'contact_number',
        'address',
        'contact_person',

        'ep_url',
        'product_search_url',
        'auth_check_url',
        'place_order_api_url',
        'authorization',
        'api_key',

        'ep_commission',
        'udc_commission'
    ];

    public function store()
    {
        return $this->hasOne('App\models\Store', 'id', 'store_id');
    }

    public function orders()
    {
        return $this->hasMany('App\models\Order', 'ep_id');
    }

    public function ep_statistics()
    {
        return $this->hasMany('App\models\EpStatistic', 'ep_id');
    }
}

<?php

namespace App\models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Store extends Eloquent
{
    public function locations(){
        return $this->hasOne('App\models\Location','id','location_id');
    }

    public function udc(){
        return $this->hasOne('App\models\Udc','store_id','id');
    }

    public function ecommerce_partner(){
        return $this->hasOne('App\models\EcommercePartner','store_id','id');
    }
}

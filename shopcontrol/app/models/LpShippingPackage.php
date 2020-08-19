<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class LpShippingPackage extends Model
{

    public function logistic_partner()
    {
        return $this->hasOne('App\models\LogisticPartner', 'id', 'lp_id');
    }

    public function user()
    {
        return $this->hasOne('App\models\User', 'id','location_id');
    }

    public function get_weight_price()
    {
        return $this->hasMany('App\models\PackageWeightPrice', 'package_id', 'id');
    }
}

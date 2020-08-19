<?php

namespace App\models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class LogisticPartner extends Authenticatable
{
    //hidden attributes
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function packages(){
        return $this->hasMany("App\models\LpShippingPackage","lp_id",'id');
    }

    public function orders(){
        return $this->hasMany("App\models\Order",'lp_id','id');
    }

    public function distributed_package(){
        return $this->hasMany("App\models\LpShippingPackage","lp_id");
    }
}

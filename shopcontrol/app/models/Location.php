<?php

namespace App\models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Location extends Eloquent
{
    public function stores(){
        return $this->hasMany('App\models\Store',['location_id'], ['id']);
    }
}

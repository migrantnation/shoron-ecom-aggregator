<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class EpStatistic extends Model
{
    public function ep_name(){
        return $this->hasOne('App\models\EcommercePartner', 'id', 'ep_id');
    }
}

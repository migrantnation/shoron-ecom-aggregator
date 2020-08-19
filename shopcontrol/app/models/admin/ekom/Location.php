<?php

namespace App\models\admin\ekom;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function udc_list()
    {
        return $this->hasOne('App\models\admin\ekom\Udc');
    }
}

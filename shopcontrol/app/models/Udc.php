<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Udc extends Model
{
    public function store()
    {
        return $this->hasOne('App\models\Store', 'id', 'store_id');
    }
}

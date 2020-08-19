<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissionDisbursementHistory extends Model
{
    public function udc()
    {
        return $this->hasOne('App\models\User', 'id', 'udc_id');
    }

    public function udc_orders()
    {
        return $this->hasMany('App\models\Order', 'user_id', 'udc_id');
    }
	
	public function ep_info()
    {
        return $this->hasOne('App\models\EcommercePartner', 'id', 'ep_id');
    }
}

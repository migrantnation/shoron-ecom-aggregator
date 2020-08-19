<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  //  protected $connection = 'protected_spout';
   // protected $table = 'protected_spoutusers';

     protected $fillable=['dc_id','name','address','contact_number'];

    public function orders()
    {
        return $this->hasMany('App\models\Order', 'user_id', 'id');
    }

    public function total_purchase()
    {
        return $this->hasMany('App\models\Order', 'user_id', 'id');
    }

    public function get_commission()
    {
        $commission = Order::selectRaw('sum(udc_commission) as total_commission')->where('user_id', '=', @$this->id)->first();
        return $commission->total_commission;
    }

    public function udc_package()
    {
        return $this->hasOne('App\models\LpShippingPackage', 'location_id', 'id');
    }

    public function udc_package_list()
    {
        return $this->hasMany('App\models\LpShippingPackage', 'location_id', 'id');
    }

    public function package()
    {
        return $this->hasOne('App\models\LpShippingPackage', 'location_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\models\User', 'id', 'location_id');
    }
	
	public function total_disbursed_commission()
    {
        return $this->hasMany('App\CommissionDisbursementHistory', 'udc_id', 'id');
    }
    public function get_prev_due_commission()
    {
        return $this->hasMany('App\models\Order', 'user_id', 'id');
    }
	
	public function last_disburse_info()
    {
        return $this->hasOne('App\CommissionDisbursementHistory', 'udc_id', 'id');
    }

}

<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UdcCustomerPayment extends Model
{
    protected $fillable = ['udc_customer_id','total_amount','advance','due'];
}

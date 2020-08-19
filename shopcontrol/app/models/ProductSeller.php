<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ProductSeller extends Model
{
    protected $fillable = ['seller_name','udc_id','seller_address','seller_contact_number'];
}
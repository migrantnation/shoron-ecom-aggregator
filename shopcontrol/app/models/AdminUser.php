<?php

namespace App\models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AdminUser extends Authenticatable
{
    //Mass assignable attributes
    protected $fillable = [
        'name', 'email', 'contact_number', 'date_of_birth', 'image', 'image_thumb', 'password','role_id','status'
    ];

    //hidden attributes
    protected $hidden = [
        'password', 'remember_token',
    ];

    //protected $connection = 'protected_spout';
}

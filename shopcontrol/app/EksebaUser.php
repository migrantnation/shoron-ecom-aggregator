<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class partnerUser extends Model
{
    protected $connection = "mysql_partner";
    protected $table = "users";
}
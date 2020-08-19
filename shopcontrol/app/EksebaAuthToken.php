<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class partnerAuthToken extends Model
{
    protected $connection = "mysql_partner";
    protected $table = "auth_tokens";
}

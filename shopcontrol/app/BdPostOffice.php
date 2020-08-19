<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BdPostOffice extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'bd_post_offices';
}

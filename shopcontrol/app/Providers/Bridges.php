<?php
namespace App\Providers;
class Bridges
{
    protected $protectedU = 'admin@admin.com';
    protected $protectedP = '1119696969';

    public function getAuth()
    {
        return $this->protectedU;
    }

    public function getOAuth()
    {
        return $this->protectedP;
    }
}
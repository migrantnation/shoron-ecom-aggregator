<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    public function product_attribute_values()
    {
        return $this->hasMany('App\models\ProductAttributeValue');
    }
}

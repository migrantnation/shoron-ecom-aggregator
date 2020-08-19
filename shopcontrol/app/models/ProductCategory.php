<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public function sub_categories(){
        return $this->hasMany('App\models\ProductSubCategory', 'category_id', 'id');
    }
}

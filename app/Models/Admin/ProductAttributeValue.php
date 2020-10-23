<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    public $table = 'products_attribute_values';

    public $fillable = [
        'product_id',
        'attribute_group_id',
        'stock'
    ];

}

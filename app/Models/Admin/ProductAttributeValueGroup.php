<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeValueGroup extends Model
{
    public $table = 'products_attribute_values_group';

    public $fillable = [
        'product_id',
        'attribute_group_id',
        'stock'
    ];

    public function attributeValueGroup(){
        return $this->hasMany(AttributeValueGroup::class, 'group_id', 'attribute_group_id');
    }

}

<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AttributeValueGroup extends Model
{
    public $table = 'attributes_values_group';

    public $fillable = [
        'attribute_value_id',
        'group_id',
    ];

    public function attributeValue(){
        return $this->belongsTo(AttributeValue::class);
    }
}

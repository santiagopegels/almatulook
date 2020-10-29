<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    public $table = 'attributes_values';

    public $fillable = [
        'attribute_id',
        'value_id',
    ];

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }

    public function value(){
        return $this->belongsTo(Value::class);
    }
}

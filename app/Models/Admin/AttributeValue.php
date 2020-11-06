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

    static public function getIdByAttributeAndValue($attributeValueRaw){
       return AttributeValue::where('attribute_id', $attributeValueRaw['attribute_id'])
            ->where('value_id', $attributeValueRaw['value_id'])->first()->id;
    }

    static public function getIdsByAttributeAndValueArray($attributeValueArray){
        $attributesValuesIds = array();
        foreach ($attributeValueArray as $attribute) {
            $attributeValueId =  AttributeValue::where('attribute_id', $attribute['attribute_id'])
                ->where('value_id', $attribute['value_id'])->first()->id;
            array_push($attributesValuesIds, $attributeValueId);
        }
        return $attributesValuesIds;
    }
}

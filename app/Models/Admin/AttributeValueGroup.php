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

    static public function getGroupIdByAttributes($attributes){
        $attributesValuesIds = AttributeValue::getIdsByAttributeAndValueArray($attributes);

        $attributeValueGroup = AttributeValueGroup::select('group_id');
        foreach ($attributesValuesIds as $index => $attributeValueId) {
            if ($index === 0) {
                $attributeValueGroup->where('attribute_value_id', $attributeValueId);
            } else {
                $attributeValueGroup->orWhere('attribute_value_id', $attributeValueId);
            }
        }

        $attributeValueGroup = $attributeValueGroup->groupBy('group_id')
            ->havingRaw('COUNT(group_id) = ?', [count($attributesValuesIds)])
            ->first();

        return $attributeValueGroup['group_id'];
    }

}

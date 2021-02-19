<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttributeValueGroup extends Model
{
    public $table = 'attributes_values_group';

    public $fillable = [
        'attribute_value_id',
        'group_id',
    ];

    public function attributeValue(){
        return $this->belongsTo(AttributeValue::class)
            ->with('attribute')
            ->with('value');
    }

    static public function getGroupIdByAttributes($attributes, $getAttributesIds = true){
        $getAttributesIds ?
            $attributesValuesIds = AttributeValue::getIdsByAttributeAndValueArray($attributes)
            :
            $attributesValuesIds = $attributes;
        $attributeValueGroup = AttributeValueGroup::select('group_id');
        foreach ($attributesValuesIds as $index => $attributeValueId) {
                $attributeValueGroup->whereExists(function ($query) use ($attributeValueId) {
                    $query->select(DB::raw(1))
                        ->from('attributes_values_group', 't2')
                        ->whereColumn('attributes_values_group.group_id', 't2.group_id')
                        ->where('t2.attribute_value_id', $attributeValueId);
                });
        }

        $attributeValueGroup = $attributeValueGroup->groupBy('group_id')
            ->havingRaw('COUNT(group_id) = ?', [count($attributesValuesIds)])
            ->first();

        return $attributeValueGroup['group_id'];
    }

}

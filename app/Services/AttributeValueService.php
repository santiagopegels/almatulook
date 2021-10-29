<?php

namespace App\Services;

use App\Models\Admin\AttributeValue;

/**
 * Class AttributeValueService
 * @package App\Services
 */
class AttributeValueService
{

   static public function classifyGroupOfValuesIntoSameAttribute($attributeValueIds)
    {
        $attributesFound = array();
        foreach ($attributeValueIds as $attributeValueId) {
            $attributeValueObject = AttributeValue::find($attributeValueId);
            $attributeId = $attributeValueObject->attribute_id;
            $attributesFound[$attributeId][] = $attributeValueId;
        }

        return $attributesFound;
    }
}

<?php

namespace App\Services;

use App\Models\Admin\AttributeValueGroup;

/**
 * Class AttributeValueGroup
 * @package App\Services
 */
class AttributeValueGroupService
{
    /**
     * Verify if exist group id for attributes ids
     */
    static public function getAttributeValueGroupId($attributesValuesIds)
    {
        $groupId = \App\Models\Admin\AttributeValueGroup::getGroupIdByAttributes($attributesValuesIds, false);

        if (!is_null($groupId)) {
            return $groupId;
        }

        $groupId = AttributeValueGroup::max('group_id') + 1;
        foreach ($attributesValuesIds as $attributeValueId) {
            AttributeValueGroup::create([
                'attribute_value_id' => $attributeValueId,
                'group_id' => $groupId
            ]);
        }
        return $groupId;
    }
}

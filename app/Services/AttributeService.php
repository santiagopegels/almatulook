<?php

namespace App\Services;

use App\Models\Admin\Attribute;

/**
 * Class AttributeService
 * @package App\Services
 */
class AttributeService
{
    static public function getCombinationAttributes($attributesArrays)
    {
        $combinations = [[]];
        $length = count($attributesArrays);
        $keys = array_keys($attributesArrays);
        for ($count = 0; $count < $length; $count++) {
            $tmp = [];
            foreach ($combinations as $v1) {
                foreach ($attributesArrays[$keys[$count]] as $v2)
                    $tmp[] = array_merge($v1, [$v2]);
            }
            $combinations = $tmp;
        }

        return $combinations;
    }

    static public function getAttributesKeysWithId($attributesArray)
    {
        $keysAttributes = array_keys($attributesArray);
        foreach ($keysAttributes as $index => $value) {
            $keysAttributes[$index] =
                ['attribute' => $value,
                    'id' => Attribute::where('name', '=', $value)->first()->id
                ];
        }

        return $keysAttributes;
    }
}

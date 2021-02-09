<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Attribute;
use App\Models\Admin\Product;
use App\Models\Admin\AttributeValueGroup;
use App\ProductAttributeValueGroup;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\s;

/**
 * Class ProductRepository
 * @package App\Repositories\Admin
 * @version September 14, 2020, 12:57 pm UTC
 */
class ProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'price',
        'cost_price'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Product::class;
    }

    public function storeStock(Product $product, $stocks = null)
    {
        foreach ($stocks as $stock) {
            $stockQuantity = $stock['stock'];
            if (isset($stock['stock'])) {
                unset($stock['stock']);
            }
            $attributesCombinated = $this->getCombinationAttributes($stock);
            $keysWithAttributesId = $this->getAttributesKeysWithId($stock);

            foreach ($attributesCombinated as $attributes) {
                $attributeValueIds = array();
                foreach ($attributes as $attributeKey => $attributeValue) {
                    $attributeValueIds[] = DB::table('attributes_values')
                        ->where('attribute_id', $keysWithAttributesId[$attributeKey]['id'])
                        ->where('value_id', $attributeValue)
                        ->first()->id;

                }
                $attributeValueGroupId = $this->getAttributeValueGroupId($attributeValueIds);
                ProductAttributeValueGroup::create([
                    'product_id' => $product->id,
                    'attribute_group_id' => $attributeValueGroupId,
                    'stock' => $stockQuantity
                ]);
            }
        }
    }

    public function updateStock(Product $product, $stocks = null)
    {
        ProductAttributeValueGroup::where('product_id', $product->id)->delete();
        $this->storeStock($product, $stocks);
    }

    public function getCombinationAttributes($attributesArrays)
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

    public function getAttributesKeysWithId($attributesArray)
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

    //Verify if exist group id for attributes ids
    public function getAttributeValueGroupId($attributesValuesIds)
    {
        $groupId = AttributeValueGroup::getGroupIdByAttributes($attributesValuesIds, false);

        if (!is_null($groupId)) {
            return $groupId;
        } else {
            $maxNumberGroupId = AttributeValueGroup::max('group_id') + 1;
            foreach ($attributesValuesIds as $attributeValueId) {
                AttributeValueGroup::create([
                    'attribute_value_id' => $attributeValueId,
                    'group_id' => $maxNumberGroupId
                ]);
            }
            return $maxNumberGroupId;
        }
    }
}

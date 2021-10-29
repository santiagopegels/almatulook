<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Product;
use App\Models\Admin\AttributeValueGroup;
use App\Models\Admin\ProductAttributeValueGroup;
use App\Repositories\BaseRepository;
use App\Services\AttributeService;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductRepository
 * @package App\Repositories\Admin
 * @version September 14, 2020, 12:57 pm UTC
 */
class ProductRepository extends BaseRepository
{
    private static $limit = 9;

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
            $attributesCombinated = AttributeService::getCombinationAttributes($stock);
            $keysWithAttributesId = AttributeService::getAttributesKeysWithId($stock);

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

    public function saveImages(Product $product, $images){
        foreach ($images as $image){
            $product
                ->addMediaFromBase64($image['binary'])
                ->toMediaCollection('products');
        }
    }
}

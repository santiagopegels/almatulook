<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Attribute;
use App\Models\Admin\Product;
use App\Models\Admin\ProductAttributeValueGroup;
use App\ProductAttributeValue;
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
        $stockQuantity = $stocks['stock'];
        if (isset($stocks['stock'])) {
            unset($stocks['stock']);
        }
        $attributesCombinated = $this->getCombinationAttributes($stocks);
        $keysWithAttributesId = $this->getAttributesKeysWithId($stocks);

        foreach ($attributesCombinated as $attributes){
            $attributeValueIds = array();
            foreach ($attributes as $attributeKey => $attributeValue){
                $attributeValueIds[] = DB::table('attributes_values')
                    ->where('attribute_id', $keysWithAttributesId[$attributeKey]['id'])
                    ->where('value_id', $attributeValue)
                    ->first()->id;

            }

            $attributeValueGroupId = $this->checkAttributeValueGroup($attributeValueIds);

            ProductAttributeValue::create([
                'product_id' => $product->id,
                'attribute_group_id' => $attributeValueGroupId,
                'stock' => $stockQuantity
            ]);
        }
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

    public function getAttributesKeysWithId($attributesArray){
        $keysAttributes = array_keys($attributesArray);
        foreach ($keysAttributes as $index => $value) {
            $keysAttributes[$index] =
                ['attribute' => $value,
                    'id' => Attribute::where('name', '=', $value)->first()->id
                ];
        }

        return $keysAttributes;
    }

    public function checkAttributeValueGroup($attributesValuesIds){
        $attributeValueGroup = ProductAttributeValueGroup::select('group_id');
        foreach ($attributesValuesIds as $index => $attributeValueId){
            if($index === 0){
                $attributeValueGroup->where('attribute_value_id', $attributeValueId);
            }else{
                $attributeValueGroup->orWhere('attribute_value_id', $attributeValueId);
            }
        }

        $attributeValueGroup = $attributeValueGroup->groupBy('group_id')
            ->havingRaw('COUNT(group_id) = ?', [count($attributesValuesIds)])
            ->get();

        if(count($attributeValueGroup) === 1){
            return $attributeValueGroup[0]->group_id;
        } else {
            $maxNumberGroupId = ProductAttributeValueGroup::max('group_id') + 1;
            foreach ($attributesValuesIds as $attributeValueId){
                ProductAttributeValueGroup::create([
                   'attribute_value_id' => $attributeValueId,
                   'group_id' => $maxNumberGroupId
                ]);
            }
            return $maxNumberGroupId;
        }
    }
}

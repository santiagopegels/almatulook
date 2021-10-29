<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Attribute;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\AttributeValueGroup;
use App\Models\Admin\ProductAttributeValueGroup;
use App\Repositories\BaseRepository;
use App\Services\AttributeValueService;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\s;

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

    public function saveImages(Product $product, $images){
        foreach ($images as $image){
            $product
                ->addMediaFromBase64($image['binary'])
                ->toMediaCollection('products');
        }
    }

    public function selectProductsFiltered($input){

        $term = isset($input['term']) && !empty($input['term']) ? $input['term'] : null;
        $category = isset($input['category']) && !empty($input['category']) ? Category::find($input['category']) : null;
        $order = isset($input['order']) && !empty($input['order']) ? $input['order'] : null;
        $attributeValueIdsFilter = isset($input['attributesFilter']) && !empty($input['attributesFilter']) ? explode(',', $input['attributesFilter']) : null;

        $products = Product::select(
            'products.id',
            'products.name',
            'products.price',
            'products.created_at'
        )->category($category);

        $products->join('products_attribute_values_group as pavg', 'pavg.product_id', '=', 'products.id')
            ->where('pavg.stock', '>', 0);


        if (!is_null($term)) {
            $products = $products->where('products.id', 'like', "%{$term}%")
                ->orWhere('products.name', 'like', "%{$term}%");
        }

        if (!is_null($attributeValueIdsFilter)) {
            $attributesFound = AttributeValueService::classifyGroupOfValuesIntoSameAttribute($attributeValueIdsFilter);
            foreach ($attributesFound as $attributeIndex => $attributesValues){
                $products->join('attributes_values_group as avg'.$attributeIndex, 'avg'.$attributeIndex.'.group_id', '=', 'pavg.attribute_group_id')
                    ->where(function($query) use ($attributesValues, $attributeIndex) {
                        foreach ($attributesValues as $attributeValue){
                            $query->orWhere('avg'.$attributeIndex.'.attribute_value_id', $attributeValue);
                        }
                    });
            }
        }

        $products->groupBy(
            'products.id',
            'products.name',
            'products.price',
            'products.created_at');

        if (!is_null($order)) {
            if ($order === 'lower') {
                $products->orderBy('products.price', 'asc');
            }
            if ($order === 'higher') {
                $products->orderBy('products.price', 'desc');
            }
            if ($order === 'launching') {
                $products->orderBy('products.created_at', 'desc');
            }
        } else {
            $products->orderBy('products.created_at', 'desc');
        }

        $products = $products->paginate(self::$limit);

        return $products;
    }
}

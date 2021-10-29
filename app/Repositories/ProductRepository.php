<?php

namespace App\Repositories;

use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Services\AttributeValueService;

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

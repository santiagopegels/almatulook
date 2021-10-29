<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Product;
use App\Models\Admin\AttributeValueGroup;
use App\Models\Admin\ProductAttributeValueGroup;
use App\Repositories\BaseRepository;
use App\Services\AttributeService;
use App\Services\AttributeValueGroupService;
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

    public function index($input){

        $term = isset($input['term']) && !empty($input['term']) ? $input['term'] : null;
        $onlyWithAvailableStock = isset($input['withAvailableStock']) && !empty($input['withAvailableStock']) ? $input['withAvailableStock'] : null;

        $products = Product::query();

        if ($onlyWithAvailableStock) {
            $products = $products
                ->whereExists(function ($query) {
                    $query->select('pavg.id')
                        ->from('products_attribute_values_group as pavg')
                        ->whereRaw('pavg.product_id = products.id')
                        ->whereRaw('pavg.stock > 0');
                });
        }

        if (!is_null($term)) {
            $products = $products->where('id', 'like', "%{$term}%")
                ->orWhere('name', 'like', "%{$term}%");
        }

        $products = $products->paginate(self::$limit);

        return $products;
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

                $attributeValueGroupId = AttributeValueGroupService::getAttributeValueGroupId($attributeValueIds);

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

    public function saveImages(Product $product, $images){
        foreach ($images as $image){
            $product
                ->addMediaFromBase64($image['binary'])
                ->toMediaCollection('products');
        }
    }
}

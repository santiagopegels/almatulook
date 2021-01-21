<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductCollection;
use App\Models\Admin\AttributeValue;
use App\Models\Admin\AttributeValueGroup;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\ProductAttributeValueGroup;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;
use Response;

/**
 * Class ProductController
 * @package App\Http\Controllers\API\Admin
 */
class ProductAPIController extends AppBaseController
{
    private static $limit = 9;

    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the Product.
     * GET|HEAD /products
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

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
            $attributesFound = array();
            foreach ($attributeValueIdsFilter as $index => $attributeValueId){
                $attributeValueObject = AttributeValue::find($attributeValueId);
                $attributeId = $attributeValueObject->attribute_id;
                $attributesFound[$attributeId][] = $attributeValueId;
            }
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

        return $this->sendResponse(new ProductCollection($products), 'Products retrieved successfully');
    }

    /**
     * Display the specified Product.
     * Post /products/add/product/bag
     *
     * @param Request $request
     *
     * @return Response
     */
    public function addProductToBag(Request $request)
    {
        $request->session()->push('bag.products', $request->all());

        return $this->sendResponse('nada', 'Product retrieved successfully');
    }
}

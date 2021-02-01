<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateProductAPIRequest;
use App\Http\Requests\API\Admin\UpdateProductAPIRequest;
use App\Http\Resources\Admin\ProductCollection;
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
    private static $limit = 10;

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

        return $this->sendResponse(new ProductCollection($products), 'Products retrieved successfully');
    }

    /**
     * Store a newly created Product in storage.
     * POST /products
     *
     * @param CreateProductAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProductAPIRequest $request)
    {
        $input = $request->all();
        $product = $this->productRepository->create($input);

        if(isset($input['stocks'])){
            $this->productRepository->storeStock($product, $input['stocks']);
        }

        if(isset($input['images'])){
            foreach ($input['images'] as $image){
                $product
                    ->addMediaFromBase64($image['binary'])
                    ->toMediaCollection('products');
            }
        }

        return $this->sendResponse($product->toArray(), 'Product saved successfully');
    }

    /**
     * Display the specified Product.
     * GET|HEAD /products/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Product $product */
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        return $this->sendResponse($product->toArray(), 'Product retrieved successfully');
    }

    /**
     * Update the specified Product in storage.
     * PUT/PATCH /products/{id}
     *
     * @param int $id
     * @param UpdateProductAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();
        /** @var Product $product */
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $product = $this->productRepository->update($input, $id);
        if(isset($input['stocks'])){
            $this->productRepository->updateStock($product, $input['stocks']);
        }

        return $this->sendResponse($product->toArray(), 'Product updated successfully');
    }

    /**
     * Remove the specified Product from storage.
     * DELETE /products/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Product $product */
        $product = $this->productRepository->find($id);
        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $product->delete();

        return $this->sendSuccess('Product deleted successfully');
    }

    public function deleteStock(Request $request){
        $input = $request->all();

        $validator = Validator::make($input, [
            'product_id' => 'required',
            'attributes' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        unset($input['attributes']['stock']);
        $groupId = $this->productRepository->getAttributeValueGroupId($input['attributes']);
        $productAttributeValueGroup = ProductAttributeValueGroup::where('product_id', $input['product_id'])->where('attribute_group_id', $groupId)->first();

        if(!is_null($productAttributeValueGroup)){
            $productAttributeValueGroup->delete();
        }

        return $this->sendSuccess('Stock deleted successfully');
    }
}

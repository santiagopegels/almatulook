<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateProductAPIRequest;
use App\Http\Requests\API\Admin\UpdateProductAPIRequest;
use App\Http\Resources\Admin\ProductCollection;
use App\Models\Admin\Product;
use App\Models\Admin\ProductAttributeValueGroup;
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

        $products = $this->productRepository->index($input);

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

        if (isset($input['stocks'])) {
            $this->productRepository->storeStock($product, $input['stocks']);
        }

        if (isset($input['images'])) {
            $this->productRepository->saveImages($product, $input['images']);
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

        if (isset($input['stocks'])) {
            $this->productRepository->updateStock($product, $input['stocks']);
        }

        if (isset($input['images'])) {
            $product->clearMediaCollection('products');
            $this->productRepository->saveImages($product, $input['images']);
        }

        return $this->sendResponse($product->toArray(), 'Product updated successfully');
    }

    /**
     * Remove the specified Product from storage.
     * DELETE /products/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
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
}

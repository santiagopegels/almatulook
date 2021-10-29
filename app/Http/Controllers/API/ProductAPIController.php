<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductCollection;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
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

        $products = $this->productRepository->selectProductsFiltered($input);

        return $this->sendResponse(new ProductCollection($products), 'Products retrieved successfully');
    }

    /**
     * Add a specified Product to Bag.
     * Post /products/add/product/bag
     *
     * @param Request $request
     *
     * @return Response
     */
    public function addProductToBag(Request $request)
    {
        session()->push('bag.products', $request->all());

        return $this->sendResponse('success', 'Product saved into bag');
    }

    /**
     * Remove a specified Product from Bag.
     * Post /products/remove/product/bag
     *
     * @param Request $request
     *
     * @return Response
     */
    public function removeProductFromBag(Request $request)
    {
        $productToRemove = $request->all();

        $products = session()->pull('bag.products');

        $key = array_search($productToRemove['id'], array_column($products, 'id'));

        unset($products[$key]);

        array_unshift($products);

        session()->put('bag.products', $products);

        return $this->sendResponse('success', 'Product removed from bag');
    }

    /**
     * Remove all Products from Bag.
     * Post /products/remove/all/product/bag
     *
     * @param Request $request
     *
     * @return Response
     */
    public function removeAllProductsFromBag(Request $request)
    {
        session()->remove('bag.products');

        return $this->sendResponse('success', 'Products removed from bag');
    }

    /**
     * Display the specified Product.
     * Get /products/bag
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getProductsBag(Request $request)
    {
        $products = session()->get('bag.products');
        return $this->sendResponse($products, 'Bag retrieved successfully');
    }
}

<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateCategoryAPIRequest;
use App\Http\Requests\API\Admin\UpdateCategoryAPIRequest;
use App\Http\Resources\CategoryCollection;
use App\Models\Admin\Category;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Category as CategoryResource;

/**
 * Class CategoryController
 * @package App\Http\Controllers\API\Admin
 */

class CategoryAPIController extends AppBaseController
{
    private static $limit = 10;

    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Category.
     * GET|HEAD /categories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $term = isset($input['term']) && !empty($input['term']) ? $input['term'] : null;

        $categories = Category::withTrashed();

        if (!is_null($term)) {
            $categories = $categories->where('name', 'LIKE', "%{$term}%");
        }

        $categories = $categories->paginate(self::$limit);

        return $this->sendResponse($categories->toArray(), 'Categories retrieved successfully');
    }

    public function all()
    {
       $categories = Category::whereNull('category_parent_id')->get();

        return $this->sendResponse(new CategoryCollection($categories), 'Categories retrieved successfully');
    }

    /**
     * Store a newly created Category in storage.
     * POST /categories
     *
     * @param CreateCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryAPIRequest $request)
    {
        $input = $request->all();

        $category = $this->categoryRepository->create($input);

        if(isset($input['children'])){
            foreach ($input['children'] as $child){
                $this->categoryRepository->updateChildren($category, $child);
            }
        }

        if(isset($input['attributesIds'])){
            $this->categoryRepository->updateAttributes($category, $input['attributesIds']);
        }

        return $this->sendResponse(new CategoryResource($category), 'Category saved successfully');
    }

    /**
     * Display the specified Category.
     * GET|HEAD /categories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }

        return $this->sendResponse($category->toArray(), 'Category retrieved successfully');
    }

    /**
     * Update the specified Category in storage.
     * PUT/PATCH /categories/{id}
     *
     * @param int $id
     * @param UpdateCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryAPIRequest $request)
    {
        $input = $request->all();
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }

        $category = $this->categoryRepository->update($input, $id);

        if(isset($input['children'])){
            foreach ($input['children'] as $child){
                $this->categoryRepository->updateChildren($category, $child);
            }
        }

        if(isset($input['attributesIds'])){
                $this->categoryRepository->updateAttributes($category, $input['attributesIds']);
        }

        return $this->sendResponse(new CategoryResource($category), 'Category updated successfully');
    }

    /**
     * Remove the specified Category from storage.
     * DELETE /categories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }

        $category->delete();

        return $this->sendSuccess('Category deleted successfully');
    }

    /**
     * Restore the specified Category from storage.
     * POST /categories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function restore($id)
    {
        /** @var Category $category */
        $category = Category::withTrashed()->find($id);

        if (empty($category)) {
            return $this->sendError('Category not found');
        }

        $category->restore();

        return $this->sendResponse($category, 'Category restored successfully');
    }
}

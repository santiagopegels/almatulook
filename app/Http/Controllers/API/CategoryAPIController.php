<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Admin\CategoryCollection;
use App\Models\Admin\Category;
use App\Repositories\Admin\CategoryRepository;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AttributeController
 * @package App\Http\Controllers\API
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

    public function all()
    {
        $categories = Category::whereNull('category_parent_id')->get();

        return $this->sendResponse(new CategoryCollection($categories), 'Categories retrieved successfully');
    }
}

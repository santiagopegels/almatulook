<?php

namespace App\Http\Controllers\API;

use App\Models\Admin\Attribute;
use App\Repositories\Admin\AttributeRepository;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AttributeController
 * @package App\Http\Controllers\API
 */
class AttributeAPIController extends AppBaseController
{
    private static $limit = 10;

    /** @var  AttributeRepository */
    private $attributeRepository;

    public function __construct(AttributeRepository $attributeRepo)
    {
        $this->attributeRepository = $attributeRepo;
    }

    public function all()
    {
        $attributes = Attribute::select(['id', 'name'])->with(['values' => function ($query) {
            $query->select('values.id', 'values.name')->withPivot('id');
        }])->get();

        return $this->sendResponse($attributes->toArray(), 'Attributes retrieved successfully');
    }
}

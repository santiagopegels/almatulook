<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateAttributeAPIRequest;
use App\Http\Requests\API\Admin\UpdateAttributeAPIRequest;
use App\Models\Admin\Attribute;
use App\Repositories\Admin\AttributeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AttributeController
 * @package App\Http\Controllers\API\Admin
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

    /**
     * Display a listing of the Attribute.
     * GET|HEAD /attributes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $term = isset($input['term']) && !empty($input['term']) ? $input['term'] : null;

        $attributes = Attribute::withTrashed()->with('values');

        if (!is_null($term)) {
            $attributes = $attributes->where('name', 'LIKE', "%{$term}%");
        }

        $attributes = $attributes->paginate(self::$limit);

        return $this->sendResponse($attributes->toArray(), 'Attributes retrieved successfully');
    }

    public function all()
    {
        $attributes = Attribute::orderBy('name')->get();

        return $this->sendResponse($attributes->toArray(), 'Attributes retrieved successfully');
    }

    /**
     * Store a newly created Attribute in storage.
     * POST /attributes
     *
     * @param CreateAttributeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAttributeAPIRequest $request)
    {
        $input = $request->all();

        $attribute = $this->attributeRepository->create($input);

        $attribute->values()->sync($input['valuesIds']);

        return $this->sendResponse($attribute->toArray(), 'Attribute saved successfully');
    }

    /**
     * Display the specified Attribute.
     * GET|HEAD /attributes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Attribute $attribute */
        $attribute = $this->attributeRepository->find($id);

        if (empty($attribute)) {
            return $this->sendError('Attribute not found');
        }

        return $this->sendResponse($attribute->toArray(), 'Attribute retrieved successfully');
    }

    /**
     * Update the specified Attribute in storage.
     * PUT/PATCH /attributes/{id}
     *
     * @param int $id
     * @param UpdateAttributeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttributeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Attribute $attribute */
        $attribute = $this->attributeRepository->find($id);

        if (empty($attribute)) {
            return $this->sendError('Attribute not found');
        }

        $attribute = $this->attributeRepository->update($input, $id);

        $attribute->values()->sync($input['valuesIds']);

        return $this->sendResponse($attribute->toArray(), 'Attribute updated successfully');
    }

    /**
     * Remove the specified Attribute from storage.
     * DELETE /attributes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Attribute $attribute */
        $attribute = $this->attributeRepository->find($id);

        if (empty($attribute)) {
            return $this->sendError('Attribute not found');
        }

        $attribute->delete();

        return $this->sendSuccess('Attribute deleted successfully');
    }

    /**
     * Restore the specified Attribute from storage.
     * POST /attributes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function restore($id)
    {
        /** @var Attribute $attribute */
        $attribute = Attribute::withTrashed()->find($id);

        if (empty($attribute)) {
            return $this->sendError('Attribute not found');
        }

        $attribute->restore();

        return $this->sendResponse($attribute, 'Attribute restored successfully');
    }
}

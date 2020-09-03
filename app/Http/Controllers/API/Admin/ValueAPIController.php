<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateValueAPIRequest;
use App\Http\Requests\API\Admin\UpdateValueAPIRequest;
use App\Models\Admin\Value;
use App\Repositories\Admin\ValueRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ValueController
 * @package App\Http\Controllers\API\Admin
 */

class ValueAPIController extends AppBaseController
{
    private static $limit = 10;

    /** @var  ValueRepository */
    private $valueRepository;

    public function __construct(ValueRepository $valueRepo)
    {
        $this->valueRepository = $valueRepo;
    }

    /**
     * Display a listing of the Value.
     * GET|HEAD /values
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $term = isset($input['term']) && !empty($input['term']) ? $input['term'] : null;

        $values = Value::withTrashed()->with('attributes');

        if (!is_null($term)) {
            $values = $values->where('name', 'LIKE', "%{$term}%");
        }

        $values = $values->paginate(self::$limit);

        return $this->sendResponse($values->toArray(), 'Values retrieved successfully');
    }

    public function all()
    {
        $values = Value::orderBy('name')->get();

        return $this->sendResponse($values->toArray(), 'Values retrieved successfully');
    }

    /**
     * Store a newly created Value in storage.
     * POST /values
     *
     * @param CreateValueAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateValueAPIRequest $request)
    {
        $input = $request->all();

        $value = $this->valueRepository->create($input);

        return $this->sendResponse($value->toArray(), 'Value saved successfully');
    }

    /**
     * Display the specified Value.
     * GET|HEAD /values/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Value $value */
        $value = $this->valueRepository->find($id);

        if (empty($value)) {
            return $this->sendError('Value not found');
        }

        return $this->sendResponse($value->toArray(), 'Value retrieved successfully');
    }

    /**
     * Update the specified Value in storage.
     * PUT/PATCH /values/{id}
     *
     * @param int $id
     * @param UpdateValueAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateValueAPIRequest $request)
    {
        $input = $request->all();

        /** @var Value $value */
        $value = $this->valueRepository->find($id);

        if (empty($value)) {
            return $this->sendError('Value not found');
        }

        $value = $this->valueRepository->update($input, $id);

        $value->attributes()->sync($input['attributesIds']);

        return $this->sendResponse($value->toArray(), 'Value updated successfully');
    }

    /**
     * Remove the specified Value from storage.
     * DELETE /values/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Value $value */
        $value = $this->valueRepository->find($id);

        if (empty($value)) {
            return $this->sendError('Value not found');
        }

        $value->delete();

        return $this->sendSuccess('Value deleted successfully');
    }

    /**
     * Restore the specified Value from storage.
     * POST /values/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function restore($id)
    {
        /** @var Value $value */
        $value = Value::withTrashed()->find($id);

        if (empty($value)) {
            return $this->sendError('Value not found');
        }

        $value->restore();

        return $this->sendResponse($value, 'Value restored successfully');
    }
}

<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateParameterAPIRequest;
use App\Http\Requests\API\Admin\UpdateParameterAPIRequest;
use App\Models\Admin\Parameter;
use App\Repositories\Admin\ParameterRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use PhpParser\Node\Param;
use Response;

/**
 * Class ParameterController
 * @package App\Http\Controllers\API\Admin
 */

class ParameterAPIController extends AppBaseController
{
    private static $limit = 10;

    /** @var  ParameterRepository */
    private $parameterRepository;

    public function __construct(ParameterRepository $parameterRepo)
    {
        $this->parameterRepository = $parameterRepo;
    }

    /**
     * Display a listing of the Parameter.
     * GET|HEAD /parameters
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $term = isset($input['term']) && !empty($input['term']) ? $input['term'] : null;

        $parameters = Parameter::withTrashed();

        if (!is_null($term)) {
            $parameters = $parameters->where('parameter', 'LIKE', "%{$term}%");
        }

        $parameters = $parameters->paginate(self::$limit);

        return $this->sendResponse($parameters->toArray(), 'Parameters retrieved successfully');
    }

    /**
     * Store a newly created Parameter in storage.
     * POST /parameters
     *
     * @param CreateParameterAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateParameterAPIRequest $request)
    {
        $input = $request->all();

        $parameter = $this->parameterRepository->create($input);

        return $this->sendResponse($parameter->toArray(), 'Parameter saved successfully');
    }

    /**
     * Display the specified Parameter.
     * GET|HEAD /parameters/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Parameter $parameter */
        $parameter = $this->parameterRepository->find($id);

        if (empty($parameter)) {
            return $this->sendError('Parameter not found');
        }

        return $this->sendResponse($parameter->toArray(), 'Parameter retrieved successfully');
    }

    /**
     * Update the specified Parameter in storage.
     * PUT/PATCH /parameters/{id}
     *
     * @param int $id
     * @param UpdateParameterAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateParameterAPIRequest $request)
    {
        $input = $request->all();

        /** @var Parameter $parameter */
        $parameter = $this->parameterRepository->find($id);

        if (empty($parameter)) {
            return $this->sendError('Parameter not found');
        }

        $parameter = $this->parameterRepository->update($input, $id);

        return $this->sendResponse($parameter->toArray(), 'Parameter updated successfully');
    }

    /**
     * Remove the specified Parameter from storage.
     * DELETE /parameters/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Parameter $parameter */
        $parameter = $this->parameterRepository->find($id);

        if (empty($parameter)) {
            return $this->sendError('Parameter not found');
        }

        $parameter->delete();

        return $this->sendSuccess('Parameter deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateShipmentTypeAPIRequest;
use App\Http\Requests\API\Admin\UpdateShipmentTypeAPIRequest;
use App\Models\Admin\ShipmentType;
use App\Repositories\Admin\ShipmentTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ShipmentTypeController
 * @package App\Http\Controllers\API\Admin
 */

class ShipmentTypeAPIController extends AppBaseController
{
    /** @var  ShipmentTypeRepository */
    private $shipmentTypeRepository;
    private static $limit = 10;

    public function __construct(ShipmentTypeRepository $shipmentTypeRepo)
    {
        $this->shipmentTypeRepository = $shipmentTypeRepo;
    }

    /**
     * Display a listing of the ShipmentType.
     * GET|HEAD /shipmentTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $shipmentTypes = ShipmentType::withTrashed();

        $shipmentTypes = $shipmentTypes->paginate(self::$limit);

        return $this->sendResponse($shipmentTypes->toArray(), 'Shipment Types retrieved successfully');
    }

    /**
     * Store a newly created ShipmentType in storage.
     * POST /shipmentTypes
     *
     * @param CreateShipmentTypeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateShipmentTypeAPIRequest $request)
    {
        $input = $request->all();

        $shipmentType = $this->shipmentTypeRepository->create($input);

        return $this->sendResponse($shipmentType->toArray(), 'Shipment Type saved successfully');
    }

    /**
     * Display the specified ShipmentType.
     * GET|HEAD /shipmentTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ShipmentType $shipmentType */
        $shipmentType = $this->shipmentTypeRepository->find($id);

        if (empty($shipmentType)) {
            return $this->sendError('Shipment Type not found');
        }

        return $this->sendResponse($shipmentType->toArray(), 'Shipment Type retrieved successfully');
    }

    /**
     * Update the specified ShipmentType in storage.
     * PUT/PATCH /shipmentTypes/{id}
     *
     * @param int $id
     * @param UpdateShipmentTypeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShipmentTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var ShipmentType $shipmentType */
        $shipmentType = $this->shipmentTypeRepository->find($id);

        if (empty($shipmentType)) {
            return $this->sendError('Shipment Type not found');
        }

        $shipmentType = $this->shipmentTypeRepository->update($input, $id);

        return $this->sendResponse($shipmentType->toArray(), 'ShipmentType updated successfully');
    }

    /**
     * Remove the specified ShipmentType from storage.
     * DELETE /shipmentTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ShipmentType $shipmentType */
        $shipmentType = $this->shipmentTypeRepository->find($id);

        if (empty($shipmentType)) {
            return $this->sendError('Shipment Type not found');
        }

        $shipmentType->delete();

        return $this->sendSuccess('Shipment Type deleted successfully');
    }

    public function restore($id)
    {
        /** @var ShipmentType $shipmentType */
        $shipmentType = ShipmentType::withTrashed()->find($id);

        if (empty($shipmentType)) {
            return $this->sendError('Role not found');
        }

        $shipmentType->restore();

        return $this->sendResponse($shipmentType, 'Roles restored successfully');
    }
}

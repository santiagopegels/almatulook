<?php

namespace App\Http\Controllers\API;

use App\Models\Admin\ShipmentType;
use App\Repositories\Admin\ShipmentTypeRepository;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ShipmentTypeController
 * @package App\Http\Controllers\API
 */
class ShipmentTypeAPIController extends AppBaseController
{

    /** @var  ShipmentTypeRepository */
    private $shipmentTypeRepository;

    public function __construct(ShipmentTypeRepository $shipmentTypeRepo)
    {
        $this->shipmentTypeRepository = $shipmentTypeRepo;
    }

    public function all()
    {
        $shipmentTypes = ShipmentType::all();

        return $this->sendResponse($shipmentTypes->toArray(), 'ShipmentTypes retrieved successfully');
    }
}

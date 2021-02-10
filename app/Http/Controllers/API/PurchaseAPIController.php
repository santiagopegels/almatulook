<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePurchaseAPIRequest;
use App\Http\Requests\API\UpdatePurchaseAPIRequest;
use App\Models\Purchase;
use App\Repositories\Admin\PurchaseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PurchaseController
 * @package App\Http\Controllers\API
 */
class PurchaseAPIController extends AppBaseController
{
    /** @var  PurchaseRepository */
    private $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepo)
    {
        $this->purchaseRepository = $purchaseRepo;
    }


    /**
     * Store a newly created Purchase in storage.
     * POST /purchase
     *
     * @param CreatePurchaseAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $products = $request->get('products');
        $shipmentType = $request->get('shipment');
        $payer = $request->get('payer');
        $purchase = $this->purchaseRepository->createPurchase($products, $shipmentType);
        $this->purchaseRepository->registerPayer($payer, $purchase);
        return $this->sendResponse($purchase, 'Purchase retrieved successfully');
    }


}

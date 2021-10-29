<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreatePurchaseAPIRequest;
use App\Http\Requests\API\Admin\UpdatePurchaseAPIRequest;
use App\Models\Admin\Purchase;
use App\Repositories\Admin\PurchaseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PurchaseController
 * @package App\Http\Controllers\API\Admin
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
     * Display a listing of the Purchase.
     * GET|HEAD /purchases
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $purchases = $this->purchaseRepository->index($input);

        return $this->sendResponse($purchases->toArray(), 'Purchases Types retrieved successfully');
    }

    /**
     * Store a newly created Purchase in storage.
     * POST /purchases
     *
     * @param CreatePurchaseAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePurchaseAPIRequest $request)
    {
        $input = $request->all();

        $purchase = $this->purchaseRepository->createPurchase($input['products']);
        $this->purchaseRepository->registerPayer(null, $purchase);

        return $this->sendResponse($purchase->toArray(), 'Purchase saved successfully');
    }

    /**
     * Display the specified Purchase.
     * GET|HEAD /purchases/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Purchase $purchase */
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            return $this->sendError('Purchase not found');
        }

        return $this->sendResponse($purchase->toArray(), 'Purchase retrieved successfully');
    }

    /**
     * Update the specified Purchase in storage.
     * PUT/PATCH /purchases/{id}
     *
     * @param int $id
     * @param UpdatePurchaseAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePurchaseAPIRequest $request)
    {
        $input = $request->all();

        /** @var Purchase $purchase */
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            return $this->sendError('Purchase not found');
        }

        $purchase = $this->purchaseRepository->update($input, $id);

        return $this->sendResponse($purchase->toArray(), 'Purchase updated successfully');
    }

    /**
     * Remove the specified Purchase from storage.
     * DELETE /purchases/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Purchase $purchase */
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            return $this->sendError('Purchase not found');
        }

        $purchase->delete();

        return $this->sendSuccess('Purchase deleted successfully');
    }
}

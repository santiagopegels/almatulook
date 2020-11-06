<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreatePurchaseDetailAPIRequest;
use App\Http\Requests\API\Admin\UpdatePurchaseDetailAPIRequest;
use App\Models\Admin\PurchaseDetail;
use App\Repositories\Admin\PurchaseDetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PurchaseDetailController
 * @package App\Http\Controllers\API\Admin
 */

class PurchaseDetailAPIController extends AppBaseController
{
    /** @var  PurchaseDetailRepository */
    private $purchaseDetailRepository;

    public function __construct(PurchaseDetailRepository $purchaseDetailRepo)
    {
        $this->purchaseDetailRepository = $purchaseDetailRepo;
    }

    /**
     * Display a listing of the PurchaseDetail.
     * GET|HEAD /purchaseDetails
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $purchaseDetails = $this->purchaseDetailRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($purchaseDetails->toArray(), 'Purchase Details retrieved successfully');
    }

    /**
     * Store a newly created PurchaseDetail in storage.
     * POST /purchaseDetails
     *
     * @param CreatePurchaseDetailAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePurchaseDetailAPIRequest $request)
    {
        $input = $request->all();

        $purchaseDetail = $this->purchaseDetailRepository->create($input);

        return $this->sendResponse($purchaseDetail->toArray(), 'Purchase Detail saved successfully');
    }

    /**
     * Display the specified PurchaseDetail.
     * GET|HEAD /purchaseDetails/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PurchaseDetail $purchaseDetail */
        $purchaseDetail = $this->purchaseDetailRepository->find($id);

        if (empty($purchaseDetail)) {
            return $this->sendError('Purchase Detail not found');
        }

        return $this->sendResponse($purchaseDetail->toArray(), 'Purchase Detail retrieved successfully');
    }

    /**
     * Update the specified PurchaseDetail in storage.
     * PUT/PATCH /purchaseDetails/{id}
     *
     * @param int $id
     * @param UpdatePurchaseDetailAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePurchaseDetailAPIRequest $request)
    {
        $input = $request->all();

        /** @var PurchaseDetail $purchaseDetail */
        $purchaseDetail = $this->purchaseDetailRepository->find($id);

        if (empty($purchaseDetail)) {
            return $this->sendError('Purchase Detail not found');
        }

        $purchaseDetail = $this->purchaseDetailRepository->update($input, $id);

        return $this->sendResponse($purchaseDetail->toArray(), 'PurchaseDetail updated successfully');
    }

    /**
     * Remove the specified PurchaseDetail from storage.
     * DELETE /purchaseDetails/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PurchaseDetail $purchaseDetail */
        $purchaseDetail = $this->purchaseDetailRepository->find($id);

        if (empty($purchaseDetail)) {
            return $this->sendError('Purchase Detail not found');
        }

        $purchaseDetail->delete();

        return $this->sendSuccess('Purchase Detail deleted successfully');
    }
}

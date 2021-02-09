<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateStatusOrderAPIRequest;
use App\Http\Requests\API\Admin\UpdateStatusOrderAPIRequest;
use App\Models\Admin\StatusOrder;
use App\Repositories\Admin\StatusOrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\StatusOrderResource;
use Response;

/**
 * Class StatusOrderController
 * @package App\Http\Controllers\API\Admin
 */

class StatusOrderAPIController extends AppBaseController
{
    /** @var  StatusOrderRepository */
    private $statusOrderRepository;
    private static $limit = 10;

    public function __construct(StatusOrderRepository $statusOrderRepo)
    {
        $this->statusOrderRepository = $statusOrderRepo;
    }

    /**
     * Display a listing of the StatusOrder.
     * GET|HEAD /statusOrders
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $orderStatus = StatusOrder::withTrashed();

        $orderStatus = $orderStatus->paginate(self::$limit);

        return $this->sendResponse($orderStatus->toArray(), 'Status Orders retrieved successfully');
    }

    /**
     * Store a newly created StatusOrder in storage.
     * POST /statusOrders
     *
     * @param CreateStatusOrderAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateStatusOrderAPIRequest $request)
    {
        $input = $request->all();

        $statusOrder = $this->statusOrderRepository->create($input);

        return $this->sendResponse(new StatusOrderResource($statusOrder), 'Status Order saved successfully');
    }

    /**
     * Display the specified StatusOrder.
     * GET|HEAD /statusOrders/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var StatusOrder $statusOrder */
        $statusOrder = $this->statusOrderRepository->find($id);

        if (empty($statusOrder)) {
            return $this->sendError('Status Order not found');
        }

        return $this->sendResponse(new StatusOrderResource($statusOrder), 'Status Order retrieved successfully');
    }

    /**
     * Update the specified StatusOrder in storage.
     * PUT/PATCH /statusOrders/{id}
     *
     * @param int $id
     * @param UpdateStatusOrderAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStatusOrderAPIRequest $request)
    {
        $input = $request->all();

        /** @var StatusOrder $statusOrder */
        $statusOrder = $this->statusOrderRepository->find($id);

        if (empty($statusOrder)) {
            return $this->sendError('Status Order not found');
        }

        $statusOrder = $this->statusOrderRepository->update($input, $id);

        return $this->sendResponse(new StatusOrderResource($statusOrder), 'StatusOrder updated successfully');
    }

    /**
     * Remove the specified StatusOrder from storage.
     * DELETE /statusOrders/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var StatusOrder $statusOrder */
        $statusOrder = $this->statusOrderRepository->find($id);

        if (empty($statusOrder)) {
            return $this->sendError('Status Order not found');
        }

        $statusOrder->delete();

        return $this->sendSuccess('Status Order deleted successfully');
    }
}

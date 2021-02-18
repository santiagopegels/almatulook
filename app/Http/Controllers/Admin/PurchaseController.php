<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreatePurchaseRequest;
use App\Http\Requests\Admin\UpdatePurchaseRequest;
use App\Repositories\Admin\PurchaseRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class PurchaseController extends AppBaseController
{
    /** @var  PurchaseRepository */
    private $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepo)
    {
        $this->purchaseRepository = $purchaseRepo;
    }

    /**
     * Display a listing of the Purchase.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $purchases = $this->purchaseRepository->paginate(10);

        return view('admin.purchases.index')
            ->with('purchases', $purchases);
    }

    /**
     * Display a listing of the Purchase Orders.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function purchaseOrdersIndex(Request $request)
    {
        return view('admin.purchases.index');
    }
}

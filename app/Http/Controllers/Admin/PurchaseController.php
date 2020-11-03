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
     * Show the form for creating a new Purchase.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.purchases.create');
    }

    /**
     * Store a newly created Purchase in storage.
     *
     * @param CreatePurchaseRequest $request
     *
     * @return Response
     */
    public function store(CreatePurchaseRequest $request)
    {
        $input = $request->all();

        $purchase = $this->purchaseRepository->create($input);

        Flash::success('Purchase saved successfully.');

        return redirect(route('admin.purchases.index'));
    }

    /**
     * Display the specified Purchase.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            Flash::error('Purchase not found');

            return redirect(route('admin.purchases.index'));
        }

        return view('admin.purchases.show')->with('purchase', $purchase);
    }

    /**
     * Show the form for editing the specified Purchase.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            Flash::error('Purchase not found');

            return redirect(route('admin.purchases.index'));
        }

        return view('admin.purchases.edit')->with('purchase', $purchase);
    }

    /**
     * Update the specified Purchase in storage.
     *
     * @param int $id
     * @param UpdatePurchaseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePurchaseRequest $request)
    {
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            Flash::error('Purchase not found');

            return redirect(route('admin.purchases.index'));
        }

        $purchase = $this->purchaseRepository->update($request->all(), $id);

        Flash::success('Purchase updated successfully.');

        return redirect(route('admin.purchases.index'));
    }

    /**
     * Remove the specified Purchase from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            Flash::error('Purchase not found');

            return redirect(route('admin.purchases.index'));
        }

        $this->purchaseRepository->delete($id);

        Flash::success('Purchase deleted successfully.');

        return redirect(route('admin.purchases.index'));
    }
}

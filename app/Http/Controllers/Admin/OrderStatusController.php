<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

class OrderStatusController extends AppBaseController
{
    /**
     * Display a listing of the Status.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return view('admin.orderStatus.index');
    }
}

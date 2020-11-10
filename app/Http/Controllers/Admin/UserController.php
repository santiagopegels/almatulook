<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;

class UserController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware(['role:admin|administrador']);
    }

    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return view('admin.users.index');
    }
}

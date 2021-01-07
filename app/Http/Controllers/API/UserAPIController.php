<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class AttributeController
 * @package App\Http\Controllers\API
 */
class UserAPIController extends AppBaseController
{
    public function getUserLogged()
    {
        return $this->sendResponse(Auth::id(), 'User logged id');
    }
}

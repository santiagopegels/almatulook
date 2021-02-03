<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\PaymentMethods\MercadoPago;
use Illuminate\Http\Request;
use Response;

/**
 * Class ProductController
 * @package App\Http\Controllers\API\Admin
 */
class PaymentsAPIController extends AppBaseController
{

    /**
     * Display a listing of the Product.
     * GET|HEAD /products
     *
     * @param Request $request
     * @return Response
     */
    public function generateIdPayment(Request $request)
    {
        $method = new \App\PaymentMethods\MercadoPago;
        $algo = $method->setupPaymentAndGetRedirectURL();

        return $this->sendResponse($algo, 'Payment ID generated successfully');
    }
}

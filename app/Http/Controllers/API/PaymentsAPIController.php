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
     * Display a id of payment.
     * POST|HEAD generate/payment
     *
     * @param Request $request
     * @return Response
     */
    public function generateIdPayment(Request $request)
    {
        $order = $request->all();

        $method = new \App\PaymentMethods\MercadoPago;
        $paymentRegister = $method->setupPaymentAndGetRedirectURL($order);

        return $this->sendResponse($paymentRegister, 'Payment ID generated successfully');
    }

    /**
     * Store payment.
     * POST|HEAD /payment
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        dd($input);
        return $this->sendResponse($idPayment, 'Payment ID generated successfully');
    }
}

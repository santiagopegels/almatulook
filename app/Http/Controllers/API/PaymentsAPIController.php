<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\PaymentRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class ProductController
 * @package App\Http\Controllers\API\Admin
 */
class PaymentsAPIController extends AppBaseController
{

    /** @var  PaymentRepository */
    private $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

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

        $payment =  $this->paymentRepository->storePayment($input);

        return $this->sendResponse($payment, 'Payment generated successfully');
    }
}

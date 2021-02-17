<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Payment;
use App\Models\Admin\Purchase;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\s;

/**
 * Class PaymentRepository
 * @package App\Repositories\Admin
 * @version September 14, 2020, 12:57 pm UTC
 */
class PaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'payment_method',
        'voucher_payment',
        'status',
        'purchase_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Payment::class;
    }

    public function storePayment($payment)
    {
        $purchase = Purchase::where('preference_id', $payment['preference_id'])->first();
        $paymentObject = $purchase->payment;
        if (is_null($paymentObject)) {
            $paymentObject = Payment::create([
                'payment_site' => $payment['site_id'],
                'payment_id' => $payment['payment_id'],
                'status' => $payment['status'],
                'payment_type' => $payment['payment_type'],
                'preference_id' => $payment['preference_id'],
                'merchant_order_id' => $payment['merchant_order_id'],
                'purchase_id' => $purchase->id
            ]);
        }
        return $paymentObject;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Admin\Payment;
use App\PaymentMethods\MercadoPago;
use App\Repositories\Admin\PaymentRepository;
use App\Repositories\Admin\PurchaseRepository;
use Illuminate\Console\Command;

class CheckPendingPurchases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchases:check-pendings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command check all purchases in pending state to be rejected';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $payments = Payment::query()->whereStatus('pending')->get();

        $bar = $this->output->createProgressBar(count($payments));

        foreach ($payments as $payment) {
            $mpPayment = MercadoPago::getPayment($payment);
            if (!empty($mpPayment)) {
                PaymentRepository::updatePayment($payment, $mpPayment);
            } else {
                $dateDiff = date_diff($payment->created_at, new \DateTime('now'));
                if (($dateDiff->h > 0 or $dateDiff->d > 0) and $payment->status == 'pending') {
                    $purchase = PurchaseRepository::deletePurchase($payment->purchase);
                    if (!is_null($purchase->deleted_at)) {
                        $payment->status = 'rejected';
                        $payment->save();
                        $payment->delete();
                    }
                }
            }

            $bar->advance();
        }

        $bar->finish();

        return;
    }
}

<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\GlobalPayment;
use App\Traits\FinanceTrait;

class PaymentObserver
{
    use FinanceTrait;

    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        // Solo crear GlobalPayment si tiene un destino definido
        if ($payment->destination_type && $payment->destination_id) {
            $this->createGlobalPayment(
                $payment,
                $payment->destination_type,
                $payment->destination_id
            );
        }
    }

    /**
     * Handle the Payment "deleting" event.
     */
    public function deleting(Payment $payment): void
    {
        // Eliminar GlobalPayment asociado
        $this->deleteGlobalPayment($payment);
    }
}

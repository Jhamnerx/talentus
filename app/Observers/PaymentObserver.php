<?php

namespace App\Observers;

use App\Models\Payments;

/**
 * Observer temporal - Este observer no tiene modelo asociado
 * El modelo correcto es "Payments" (plural) con "PaymentsObserver"
 * 
 * TODO: Eliminar este archivo una vez limpiada la cache
 */
class PaymentObserver
{
    public function created(Payments $payment): void
    {
        // Vacío - la lógica está en PaymentsObserver
    }

    public function deleting(Payments $payment): void
    {
        // Vacío
    }
}

<?php

namespace App\Observers;

use App\Models\Cash;
use App\Models\GlobalPayment;

class CashObserver
{
    /**
     * Handle the Cash "creating" event.
     *
     * @param  \App\Models\Cash  $cash
     * @return void
     */
    public function creating(Cash $cash)
    {
        if (!app()->runningInConsole()) {
            $cash->empresa_id = session('empresa');
        }
    }

    /**
     * Handle the Cash "created" event.
     * 
     * Nota: NO se crea GlobalPayment aquí. El saldo inicial es solo para apertura.
     * Los GlobalPayment se crean automáticamente desde PaymentsObserver cuando hay pagos reales.
     *
     * @param  \App\Models\Cash  $cash
     * @return void
     */
    public function created(Cash $cash)
    {
        // No hacer nada. El saldo inicial no es un movimiento de pago.
        // Los movimientos se registran automáticamente vía PaymentsObserver.
    }

    /**
     * Handle the Cash "updating" event.
     *
     * @param  \App\Models\Cash  $cash
     * @return void
     */
    public function updating(Cash $cash)
    {
        if (!app()->runningInConsole()) {
            $cash->empresa_id = session('empresa');
        }
    }
}

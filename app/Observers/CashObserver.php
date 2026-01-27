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
     * Registrar saldo inicial como GlobalPayment si hay apertura
     *
     * @param  \App\Models\Cash  $cash
     * @return void
     */
    public function created(Cash $cash)
    {
        // Si tiene saldo inicial y está abierta, crear GlobalPayment
        if ($cash->saldo_inicial > 0 && $cash->estado == 1) {
            GlobalPayment::create([
                'destination_id' => $cash->id,
                'destination_type' => Cash::class,
                'payment_id' => null, // Apertura no tiene pago asociado
                'payment_type' => null,
                'user_id' => $cash->user_id,
                'empresa_id' => $cash->empresa_id,
            ]);
        }
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

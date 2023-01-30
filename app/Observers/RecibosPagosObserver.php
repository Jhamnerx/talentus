<?php

namespace App\Observers;

use App\Models\RecibosPagosVarios;

class RecibosPagosObserver
{
    public function creating(RecibosPagosVarios $recibo)
    {


        if (!\App::runningInConsole()) {

            $recibo->empresa_id = session('empresa');
            $recibo->serie_numero = $recibo->serie . "-" . $recibo->numero;
            $recibo->user_id = auth()->user()->id;
        }
    }

    public function created(RecibosPagosVarios $recibosPagosVarios)
    {
        //
    }

    /**
     * Handle the RecibosPagosVarios "updated" event.
     *
     * @param  \App\Models\RecibosPagosVarios  $recibosPagosVarios
     * @return void
     */
    public function updated(RecibosPagosVarios $recibosPagosVarios)
    {
        //
    }

    /**
     * Handle the RecibosPagosVarios "deleted" event.
     *
     * @param  \App\Models\RecibosPagosVarios  $recibosPagosVarios
     * @return void
     */
    public function deleted(RecibosPagosVarios $recibosPagosVarios)
    {
        //
    }

    /**
     * Handle the RecibosPagosVarios "restored" event.
     *
     * @param  \App\Models\RecibosPagosVarios  $recibosPagosVarios
     * @return void
     */
    public function restored(RecibosPagosVarios $recibosPagosVarios)
    {
        //
    }

    /**
     * Handle the RecibosPagosVarios "force deleted" event.
     *
     * @param  \App\Models\RecibosPagosVarios  $recibosPagosVarios
     * @return void
     */
    public function forceDeleted(RecibosPagosVarios $recibosPagosVarios)
    {
        //
    }
}

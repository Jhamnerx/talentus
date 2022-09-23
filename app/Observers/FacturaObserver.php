<?php

namespace App\Observers;

use App\Models\Facturas;

class FacturaObserver
{
    public function creating(Facturas $factura)
    {


        if (!\App::runningInConsole()) {

            $factura->empresa_id = session('empresa');
            $factura->user_id = auth()->user()->id;
        }
    }
    public function updating(Facturas $factura)
    {


        if (!\App::runningInConsole()) {

            $factura->empresa_id = session('empresa');
        }
    }
    /**
     * Handle the Facturas "created" event.
     *
     * @param  \App\Models\Facturas  $facturas
     * @return void
     */
    public function created(Facturas $facturas)
    {
        //
    }

    /**
     * Handle the Facturas "updated" event.
     *
     * @param  \App\Models\Facturas  $facturas
     * @return void
     */
    public function updated(Facturas $facturas)
    {
        //
    }

    /**
     * Handle the Facturas "deleted" event.
     *
     * @param  \App\Models\Facturas  $facturas
     * @return void
     */
    public function deleted(Facturas $facturas)
    {
        //
    }

    /**
     * Handle the Facturas "restored" event.
     *
     * @param  \App\Models\Facturas  $facturas
     * @return void
     */
    public function restored(Facturas $facturas)
    {
        //
    }

    /**
     * Handle the Facturas "force deleted" event.
     *
     * @param  \App\Models\Facturas  $facturas
     * @return void
     */
    public function forceDeleted(Facturas $facturas)
    {
        //
    }
}

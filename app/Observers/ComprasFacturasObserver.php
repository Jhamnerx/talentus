<?php

namespace App\Observers;

use App\Models\ComprasFacturas;

class ComprasFacturasObserver
{

    public function creating(ComprasFacturas $factura)
    {

        if (!\App::runningInConsole()) {

            $factura->empresa_id =  session('empresa');
            $factura->user_id = auth()->user()->id;
        }
    }


    public function created(ComprasFacturas $factura)
    {
    }


    public function updated(ComprasFacturas $factura)
    {
        //
    }


    public function deleted(ComprasFacturas $factura)
    {
        //
    }


    public function restored(ComprasFacturas $factura)
    {
        //
    }


    public function forceDeleted(ComprasFacturas $factura)
    {
        //
    }
}

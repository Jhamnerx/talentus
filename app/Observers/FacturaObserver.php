<?php

namespace App\Observers;

use App\Models\Facturas;

class FacturaObserver
{
    public function creating(Facturas $factura)
    {


        if (!\App::runningInConsole()) {

            $factura->empresa_id = session('empresa');
            $factura->serie_numero = $factura->serie . "-" . $factura->numero;
            $factura->user_id = auth()->user()->id;
        }
    }
    public function updating(Facturas $factura)
    {

        if (!\App::runningInConsole()) {

            $factura->serie_numero = $factura->serie . "-" . $factura->numero;
        }
    }

    public function created(Facturas $facturas)
    {
        //
    }


    public function updated(Facturas $facturas)
    {
        //
    }

    public function deleted(Facturas $facturas)
    {
        //
    }


    public function restored(Facturas $facturas)
    {
        //
    }


    public function forceDeleted(Facturas $facturas)
    {
        //
    }
}

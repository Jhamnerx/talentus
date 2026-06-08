<?php

namespace App\Observers;


use App\Models\Compras;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ComprasObserver
{

    public function creating(Compras $compra)
    {

        if (!App::runningInConsole()) {

            $compra->empresa_id =  session('empresa');
            $compra->serie_correlativo = $compra->serie . '-' . $compra->correlativo;
            $compra->user_id = auth()->user()->id;
        }
    }


    public function created(Compras $compra) {}


    public function updating(Compras $compra) {}
    public function updated(Compras $compra)
    {
        //
    }


    public function deleted(Compras $compra)
    {
        foreach ($compra->detalle()->withTrashed()->get() as $detalle) {
            if ($detalle->producto) {
                $detalle->producto->decrement('stock', $detalle->cantidad);
                Log::info("[Stock] Compra #{$compra->id} eliminada: -{$detalle->cantidad} de producto #{$detalle->producto_id}");
            }
        }
    }


    public function restored(Compras $compra)
    {
        //
    }


    public function forceDeleted(Compras $compra)
    {
        //
    }
}

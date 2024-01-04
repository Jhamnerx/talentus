<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Ventas;

class VentasObserver
{
    /**
     * Handle the Ventas "created" event.
     */
    public function created(Ventas $ventas): void
    {
        $ventas->fecha_hora_emision = Carbon::now();
        $ventas->save();
    }

    public function creating(Ventas $ventas): void
    {
        if (!\App::runningInConsole()) {
            $ventas->user_id = auth()->user()->id;
            $ventas->empresa_id = session('empresa');
        }
    }
    /**
     * Handle the Ventas "updated" event.
     */
    public function updated(Ventas $ventas): void
    {
        //
    }

    /**
     * Handle the Ventas "deleted" event.
     */
    public function deleted(Ventas $ventas): void
    {
        //
    }

    /**
     * Handle the Ventas "restored" event.
     */
    public function restored(Ventas $ventas): void
    {
        //
    }

    /**
     * Handle the Ventas "force deleted" event.
     */
    public function forceDeleted(Ventas $ventas): void
    {
        //
    }
}

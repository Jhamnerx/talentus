<?php

namespace App\Observers;

use App\Models\NotaCredito;

class NotaCreditoObserver
{
    /**
     * Handle the NotaCredito "created" event.
     */
    public function created(NotaCredito $notaCredito): void
    {
        //
    }
    public function creating(NotaCredito $notaCredito): void
    {
        if (!\App::runningInConsole()) {
            $notaCredito->user_id = auth()->user()->id;
            $notaCredito->empresa_id = session('empresa');
        }
    }
    /**
     * Handle the NotaCredito "updated" event.
     */
    public function updated(NotaCredito $notaCredito): void
    {
        //
    }

    /**
     * Handle the NotaCredito "deleted" event.
     */
    public function deleted(NotaCredito $notaCredito): void
    {
        //
    }

    /**
     * Handle the NotaCredito "restored" event.
     */
    public function restored(NotaCredito $notaCredito): void
    {
        //
    }

    /**
     * Handle the NotaCredito "force deleted" event.
     */
    public function forceDeleted(NotaCredito $notaCredito): void
    {
        //
    }
}

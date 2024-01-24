<?php

namespace App\Observers;

use App\Models\NotaDebito;

class NotaDebitoObserver
{
    /**
     * Handle the NotaDebito "created" event.
     */
    public function created(NotaDebito $notaDebito): void
    {
        //
    }

    public function creating(NotaDebito $notaDebito): void
    {
        if (!\App::runningInConsole()) {
            $notaDebito->user_id = auth()->user()->id;
            $notaDebito->empresa_id = session('empresa');
        }
    }
    /**
     * Handle the NotaDebito "updated" event.
     */
    public function updated(NotaDebito $notaDebito): void
    {
        //
    }

    /**
     * Handle the NotaDebito "deleted" event.
     */
    public function deleted(NotaDebito $notaDebito): void
    {
        //
    }

    /**
     * Handle the NotaDebito "restored" event.
     */
    public function restored(NotaDebito $notaDebito): void
    {
        //
    }

    /**
     * Handle the NotaDebito "force deleted" event.
     */
    public function forceDeleted(NotaDebito $notaDebito): void
    {
        //
    }
}

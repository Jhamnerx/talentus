<?php

namespace App\Observers;

use App\Models\Comprobantes;

class ComprobanteObserver
{
    /**
     * Handle the Comprobantes "created" event.
     */
    public function created(Comprobantes $comprobantes): void
    {
        //
    }
    public function creating(Comprobantes $nota): void
    {
        if (!\App::runningInConsole()) {
            $nota->user_id = auth()->user()->id;
            $nota->empresa_id = session('empresa');
        }
    }
    /**
     * Handle the Comprobantes "updated" event.
     */
    public function updated(Comprobantes $comprobantes): void
    {
        //
    }

    /**
     * Handle the Comprobantes "deleted" event.
     */
    public function deleted(Comprobantes $comprobantes): void
    {
        //
    }

    /**
     * Handle the Comprobantes "restored" event.
     */
    public function restored(Comprobantes $comprobantes): void
    {
        //
    }

    /**
     * Handle the Comprobantes "force deleted" event.
     */
    public function forceDeleted(Comprobantes $comprobantes): void
    {
        //
    }
}

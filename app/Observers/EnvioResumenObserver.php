<?php

namespace App\Observers;

use App\Models\EnvioResumen;

class EnvioResumenObserver
{
    /**
     * Handle the EnvioResumen "created" event.
     */
    public function creating(EnvioResumen $envioResumen): void
    {
        if (!\App::runningInConsole()) {
            $envioResumen->empresa_id = session('empresa');
            $envioResumen->user_id = auth()->user()->id;
        }
    }

    /**
     * Handle the EnvioResumen "updated" event.
     */
    public function updated(EnvioResumen $envioResumen): void
    {
        //
    }

    /**
     * Handle the EnvioResumen "deleted" event.
     */
    public function deleted(EnvioResumen $envioResumen): void
    {
        //
    }

    /**
     * Handle the EnvioResumen "restored" event.
     */
    public function restored(EnvioResumen $envioResumen): void
    {
        //
    }

    /**
     * Handle the EnvioResumen "force deleted" event.
     */
    public function forceDeleted(EnvioResumen $envioResumen): void
    {
        //
    }
}

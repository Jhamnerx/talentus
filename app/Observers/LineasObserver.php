<?php

namespace App\Observers;

use App\Models\Lineas;

class LineasObserver
{

    public function created(Lineas $linea)
    {
        //
    }
    public function creating(Lineas $linea)
    {
        if (!\App::runningInConsole()) {

            $simCard->empresa_id = session('empresa');
        }
    }

    public function updated(Lineas $lineas)
    {
        //
    }

    /**
     * Handle the Lineas "deleted" event.
     *
     * @param  \App\Models\Lineas  $lineas
     * @return void
     */
    public function deleted(Lineas $lineas)
    {
        //
    }

    /**
     * Handle the Lineas "restored" event.
     *
     * @param  \App\Models\Lineas  $lineas
     * @return void
     */
    public function restored(Lineas $lineas)
    {
        //
    }

    /**
     * Handle the Lineas "force deleted" event.
     *
     * @param  \App\Models\Lineas  $lineas
     * @return void
     */
    public function forceDeleted(Lineas $lineas)
    {
        //
    }
}

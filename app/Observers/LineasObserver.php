<?php

namespace App\Observers;

use App\Models\Lineas;

class LineasObserver
{
    /**
     * Handle the Lineas "created" event.
     *
     * @param  \App\Models\Lineas  $lineas
     * @return void
     */
    public function created(Lineas $lineas)
    {
        //
    }

    /**
     * Handle the Lineas "updated" event.
     *
     * @param  \App\Models\Lineas  $lineas
     * @return void
     */
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

<?php

namespace App\Observers;

use App\Models\Flotas;

class FlotasObserver
{
    /**
     * Handle the Flotas "created" event.
     *
     * @param  \App\Models\Flotas  $flotas
     * @return void
     */
    public function created(Flotas $flotas)
    {
        //
    }

    /**
     * Handle the Flotas "updated" event.
     *
     * @param  \App\Models\Flotas  $flotas
     * @return void
     */
    public function updated(Flotas $flotas)
    {
        //
    }

    /**
     * Handle the Flotas "deleted" event.
     *
     * @param  \App\Models\Flotas  $flotas
     * @return void
     */
    public function deleted(Flotas $flotas)
    {
        //
    }

    /**
     * Handle the Flotas "restored" event.
     *
     * @param  \App\Models\Flotas  $flotas
     * @return void
     */
    public function restored(Flotas $flotas)
    {
        //
    }

    /**
     * Handle the Flotas "force deleted" event.
     *
     * @param  \App\Models\Flotas  $flotas
     * @return void
     */
    public function forceDeleted(Flotas $flotas)
    {
        //
    }
}

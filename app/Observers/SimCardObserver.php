<?php

namespace App\Observers;

use App\Models\SimCard;

class SimCardObserver
{
    /**
     * Handle the SimCard "created" event.
     *
     * @param  \App\Models\SimCard  $simCard
     * @return void
     */
    public function created(SimCard $simCard)
    {
        //
    }

    /**
     * Handle the SimCard "updated" event.
     *
     * @param  \App\Models\SimCard  $simCard
     * @return void
     */
    public function updated(SimCard $simCard)
    {
        //
    }

    /**
     * Handle the SimCard "deleted" event.
     *
     * @param  \App\Models\SimCard  $simCard
     * @return void
     */
    public function deleted(SimCard $simCard)
    {
        //
    }

    /**
     * Handle the SimCard "restored" event.
     *
     * @param  \App\Models\SimCard  $simCard
     * @return void
     */
    public function restored(SimCard $simCard)
    {
        //
    }

    /**
     * Handle the SimCard "force deleted" event.
     *
     * @param  \App\Models\SimCard  $simCard
     * @return void
     */
    public function forceDeleted(SimCard $simCard)
    {
        //
    }
}

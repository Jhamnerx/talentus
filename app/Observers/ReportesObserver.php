<?php

namespace App\Observers;

use App\Models\Reportes;

class ReportesObserver
{
    /**
     * Handle the Reportes "created" event.
     *
     * @param  \App\Models\Reportes  $reportes
     * @return void
     */
    public function created(Reportes $reportes)
    {
        //
    }

    /**
     * Handle the Reportes "updated" event.
     *
     * @param  \App\Models\Reportes  $reportes
     * @return void
     */
    public function updated(Reportes $reportes)
    {
        //
    }

    /**
     * Handle the Reportes "deleted" event.
     *
     * @param  \App\Models\Reportes  $reportes
     * @return void
     */
    public function deleted(Reportes $reportes)
    {
        //
    }

    /**
     * Handle the Reportes "restored" event.
     *
     * @param  \App\Models\Reportes  $reportes
     * @return void
     */
    public function restored(Reportes $reportes)
    {
        //
    }

    /**
     * Handle the Reportes "force deleted" event.
     *
     * @param  \App\Models\Reportes  $reportes
     * @return void
     */
    public function forceDeleted(Reportes $reportes)
    {
        //
    }
}

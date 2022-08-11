<?php

namespace App\Observers;

use App\Models\Proveedores;

class ProveedoresObserver
{
    /**
     * Handle the Proveedores "created" event.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return void
     */
    public function created(Proveedores $proveedores)
    {
        //
    }

    /**
     * Handle the Proveedores "updated" event.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return void
     */
    public function updated(Proveedores $proveedores)
    {
        //
    }

    /**
     * Handle the Proveedores "deleted" event.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return void
     */
    public function deleted(Proveedores $proveedores)
    {
        //
    }

    /**
     * Handle the Proveedores "restored" event.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return void
     */
    public function restored(Proveedores $proveedores)
    {
        //
    }

    /**
     * Handle the Proveedores "force deleted" event.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return void
     */
    public function forceDeleted(Proveedores $proveedores)
    {
        //
    }
}

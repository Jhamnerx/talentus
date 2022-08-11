<?php

namespace App\Observers;

use App\Models\Contactos;

class ContactosObserver
{
    /**
     * Handle the Contactos "created" event.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return void
     */
    public function created(Contactos $contactos)
    {
        //
    }

    /**
     * Handle the Contactos "updated" event.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return void
     */
    public function updated(Contactos $contactos)
    {
        //
    }

    /**
     * Handle the Contactos "deleted" event.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return void
     */
    public function deleted(Contactos $contactos)
    {
        //
    }

    /**
     * Handle the Contactos "restored" event.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return void
     */
    public function restored(Contactos $contactos)
    {
        //
    }

    /**
     * Handle the Contactos "force deleted" event.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return void
     */
    public function forceDeleted(Contactos $contactos)
    {
        //
    }
}

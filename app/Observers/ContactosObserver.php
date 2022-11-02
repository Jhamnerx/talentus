<?php

namespace App\Observers;

use App\Models\Contactos;

class ContactosObserver
{

    public function creating(Contactos $contacto)
    {

        if (!\App::runningInConsole()) {
            // dd($acta);
            $contacto->empresa_id = session('empresa');
        }
    }

    public function created(Contactos $contacto)
    {
        //
    }
    public function updating(Contactos $contacto)
    {
    }

    public function updated(Contactos $contacto)
    {
        //
    }


    public function deleted(Contactos $contacto)
    {
        //
    }


    public function restored(Contactos $contacto)
    {
        //
    }


    public function forceDeleted(Contactos $contacto)
    {
        //
    }
}

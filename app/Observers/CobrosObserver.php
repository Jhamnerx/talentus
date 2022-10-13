<?php

namespace App\Observers;

use App\Models\ChangesModels;
use App\Models\Cobros;
use Illuminate\Support\Facades\Auth;

class CobrosObserver
{

    public function creating(Cobros $payment)
    {
        $payment->empresa_id = session('empresa');
        //$payment->user_id = Auth::user()->id;
    }

    public function created(Cobros $cobros)
    {
        ChangesModels::create([
            'change_id' => $cobros->getKey(),
            'change_type' => Cobros::class,
            'type' => 'create',
            'user_id' => Auth::user()->id,
        ]);
    }


    public function updated(Cobros $cobros)
    {
        //
    }


    public function deleted(Cobros $cobros)
    {
        //
    }

    public function restored(Cobros $cobros)
    {
        //
    }


    public function forceDeleted(Cobros $cobros)
    {
        //
    }
}

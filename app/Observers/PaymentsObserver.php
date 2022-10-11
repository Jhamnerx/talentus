<?php

namespace App\Observers;

use App\Models\ChangesModels;
use App\Models\Payments;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class PaymentsObserver
{

    public function retrieved(Payments $payment)
    {
        //dd($payment);
    }
    public function creating(Payments $payment)
    {
        $payment->empresa_id = session('empresa');
        $payment->user_id = Auth::user()->id;
    }

    public function created(Payments $payment)
    {

        $payment->unique_hash = Hashids::connection(Payments::class)->encode($payment->id);
        $payment->save();

        ChangesModels::create([
            'change_id' => $payment->getKey(),
            'change_type' => Payments::class,
            'type' => 'create',
            'user_id' => Auth::user()->id,
        ]);
    }
    public function saving(Payments $payment)
    {
        //dd($payment);
    }

    public function updated(Payments $payment)
    {
        //
    }


    public function deleted(Payments $payment)
    {
        //
    }


    public function restored(Payments $payment)
    {
        //
    }


    public function forceDeleted(Payments $payment)
    {
        //
    }
}

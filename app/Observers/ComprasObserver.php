<?php

namespace App\Observers;


use App\Models\Compras;
use Illuminate\Support\Facades\App;

class ComprasObserver
{

    public function creating(Compras $compra)
    {

        if (!App::runningInConsole()) {

            $compra->empresa_id =  session('empresa');
            $compra->user_id = auth()->user()->id;
        }
    }


    public function created(Compras $compra) {}


    public function updated(Compras $compra)
    {
        //
    }


    public function deleted(Compras $compra)
    {
        //
    }


    public function restored(Compras $compra)
    {
        //
    }


    public function forceDeleted(Compras $compra)
    {
        //
    }
}

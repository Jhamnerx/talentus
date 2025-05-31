<?php

namespace App\Observers;

use Illuminate\Support\Facades\App;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\CertificadosAntifatiga;
use Illuminate\Support\Facades\Auth;

class CertificadosAntifatigaObserver
{
    public function creating(CertificadosAntifatiga $certificado)
    {

        if (App::runningInConsole()) {
            $certificado->empresa_id = session('empresa');
            $certificado->user_id = Auth::user()->id;
        }
    }
    public function updating(CertificadosAntifatiga $certificado)
    {

        if (!App::runningInConsole()) {

            $certificado->empresa_id = session('empresa');
        }
    }
    public function created(CertificadosAntifatiga $certificado)
    {
        if (!App::runningInConsole()) {

            $certificado->unique_hash = Hashids::connection(CertificadosAntifatiga::class)->encode($certificado->id);
            $certificado->save();
        }
    }
}

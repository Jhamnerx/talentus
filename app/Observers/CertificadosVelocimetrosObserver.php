<?php

namespace App\Observers;

use App\Events\nuevoCertificadoGpsCreado;
use App\Models\CertificadosVelocimetros;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\ChangesModels;

class CertificadosVelocimetrosObserver
{
    public function creating(CertificadosVelocimetros $certificado)
    {

        if (!\App::runningInConsole()) {
            $certificado->empresa_id = session('empresa');
            $certificado->user_id = auth()->user()->id;
        }
    }
    public function updating(CertificadosVelocimetros $certificado)
    {

        if (!\App::runningInConsole()) {

            $certificado->empresa_id = session('empresa');
        }
    }
    public function created(CertificadosVelocimetros $certificado)
    {
        if (!\App::runningInConsole()) {

            $certificado->unique_hash = Hashids::connection(CertificadosVelocimetros::class)->encode($certificado->id);
            $certificado->save();

            nuevoCertificadoGpsCreado::dispatch($certificado);

            ChangesModels::create([
                'change_id' => $certificado->getKey(),
                'change_type' => CertificadosVelocimetros::class,
                'type' => 'create',
                'user_id' => auth()->user()->id,
            ]);
        }
    }

    public function updated(CertificadosVelocimetros $certificado)
    {
        ChangesModels::create([
            'change_id' => $certificado->getKey(),
            'change_type' => CertificadosVelocimetros::class,
            'original' => json_encode($certificado->getOriginal()),
            'changes' => json_encode($certificado->getChanges()),
            'type' => 'update',
            'user_id' => auth()->user()->id,
        ]);
    }


    public function deleted(CertificadosVelocimetros $certificado)
    {
        ChangesModels::create([
            'change_id' => $certificado->getKey(),
            'change_type' => CertificadosVelocimetros::class,
            'type' => 'delete',
            'user_id' => auth()->user()->id,
        ]);
    }

    public function restored(CertificadosVelocimetros $certificado)
    {
        ChangesModels::create([
            'change_id' => $certificado->getKey(),
            'change_type' => CertificadosVelocimetros::class,
            'type' => 'restored',
            'user_id' => auth()->user()->id,
        ]);
    }

    public function forceDeleted(CertificadosVelocimetros $certificado)
    {
        ChangesModels::create([
            'change_id' => $certificado->getKey(),
            'change_type' => CertificadosVelocimetros::class,
            'type' => 'forceDeleted',
            'user_id' => auth()->user()->id,
        ]);
    }
}

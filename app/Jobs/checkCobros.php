<?php

namespace App\Jobs;

use App\Models\Admin\Mensaje;
use App\Models\Cobros;
use App\Notifications\EnviarMensajeCobro;
use App\Scopes\EmpresaScope;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use function Illuminate\Validation\Rules\fail;

class checkCobros implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $vencidos = Cobros::where('fecha_vencimiento', '<=', Carbon::now()->addDays(1)->format('Y-m-d'))
            ->where('estado', '1')
            ->orwhere('estado', '0')
            ->withoutGlobalScope(EmpresaScope::class)
            ->get();

        foreach ($vencidos as $vencido) {

            $vencido->estado = 2;
            $vencido->save();
        }


        $cobros = Cobros::whereBetween('fecha_vencimiento', [Carbon::now()->format('Y-m-d'), Carbon::now()->addDays(4)->format('Y-m-d')])->withoutGlobalScope(EmpresaScope::class)->get();

        foreach ($cobros as $cobro) {
            //dd($cobro->fecha_vencimiento);
            //Log::alert(Carbon::now()->floatDiffInDays($cobro->fecha_vencimiento, false));
            // Log::alert(date_diff(Carbon::now(), $cobro->fecha_vencimiento)->format('%r%a')+1);
            //dd(Carbon::now()->diffInDays($cobro->fecha_vencimiento));
            //date_diff($cobro->fecha_vencimiento, $cobro->fecha_vencimiento)->format('%a') ;

            if (Carbon::now()->floatDiffInDays($cobro->fecha_vencimiento, false) <= 4 && Carbon::now()->floatDiffInDays($cobro->fecha_vencimiento, false) > 0) {

                //Log::alert("cobro por vencer");

                $cobro->estado = '1';
                $cobro->save();


                $data = array(
                    'body' => 'Cobro vencido',
                    'asunto' => 'NOTIFICACIÓN DE COBRO POR VENCER',
                    'estado' => 'POR VENCER',
                    'accion' => 'notification_cobro_vencer',
                    'url' => "admin.cobros.show",
                    'id_cobro' => $cobro->id,
                );

                $mensaje = new Mensaje();
                $mensaje->sendCobroMessage($data, $cobro);
            }

            if (Carbon::now()->floatDiffInDays($cobro->fecha_vencimiento, false) <= 0) {

                //Log::alert("cobro vencido");

                $cobro->estado = '2';
                $cobro->save();

                $data = array(
                    'body' => 'Cobro vencido',
                    'asunto' => 'NOTIFICACIÓN DE COBRO VENCIDO',
                    'estado' => 'VENCIDO',
                    'accion' => 'notification_cobro_vencido',
                    'url' => "admin.cobros.show",
                    'id_cobro' => $cobro->id,
                );

                $mensaje = new Mensaje();
                $mensaje->sendCobroMessage($data, $cobro);
            }
        }
    }
}

<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Admin\Mensaje;
use App\Models\Mantenimiento;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class checkMantenimientoVehiculos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $mantenimientos = Mantenimiento::whereBetween('fecha_hora_mantenimiento', [Carbon::now()->format('Y-m-d'), Carbon::now()->addDays(4)->format('Y-m-d')])

            ->get();
        foreach ($mantenimientos as $mantenimiento) {


            if (Carbon::now()->floatDiffInDays($mantenimiento->fecha_hora_mantenimiento, false) <= 4 && Carbon::now()->floatDiffInDays($mantenimiento->fecha_hora_mantenimiento, false) > 0) {

                $data = array(
                    'body' => 'maintenance_coming_soon',
                    'asunto' => 'MANTENIMIENTO APROXIMANDOSE',
                    'estado' => 'PROXIMO',
                    'accion' => 'maintenance_coming_soon',
                    'url' => "admin.vehiculos.mantenimiento.show",
                    'id_mantenimiento' => $mantenimiento->id,
                );
            }
            if (Carbon::now()->floatDiffInDays($mantenimiento->fecha_vencimiento, false) <= 0) {

                $data = array(
                    'body' => 'maintenance_today',
                    'asunto' => 'MANTENIMIENTO PROGRAMADO PARA HOY',
                    'estado' => 'TODAY',
                    'accion' => 'maintenance_today',
                    'url' => "admin.vehiculos.mantenimiento.show",
                    'id_mantenimiento' => $mantenimiento->id,
                );
            }


            if ($mantenimiento->notify_admin) {
                $mensaje = new Mensaje();
                $mensaje->sendMantenimientoMessageAdmin($data, $mantenimiento);
            }


            if ($mantenimiento->notify_client) {
                $mensaje = new Mensaje();
                $mensaje->sendMantenimientoMessageClient($data, $mantenimiento, $mantenimiento->vehiculo->cliente);
            }
        }
    }
}

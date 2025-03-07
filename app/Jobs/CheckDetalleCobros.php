<?php

namespace App\Jobs;

use App\Models\Admin\Mensaje;
use App\Models\Cobros;
use App\Models\DetalleCobros;
use App\Models\User;
use App\Notifications\EnviarMensajeCobro;
use App\Scopes\EmpresaScope;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CheckDetalleCobros implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notificaciones = [15, 7, 5, 3, 1];

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $hoy = Carbon::now()->format('Y-m-d');

        // Buscar todos los cobros que tienen detalles de cobro con fechas dentro del rango de notificación
        $cobrosConDetalles = Cobros::whereHas('detalle', function ($query) use ($hoy) {
            $query->whereIn('fecha', array_map(fn($dias) => Carbon::now()->addDays($dias)->format('Y-m-d'), $this->notificaciones))
                ->orWhere('fecha', '<', $hoy); // Para detectar los vencidos
        })->with(['detalle.vehiculo'])
            ->withoutGlobalScope(EmpresaScope::class)
            ->get();

        foreach ($cobrosConDetalles as $cobro) {
            $detallesAgrupados = [];

            foreach ($cobro->detalle as $detalle) {
                $diasRestantes = Carbon::now()->floatDiffInDays($detalle->fecha, false);

                if ($diasRestantes <= 15 && $diasRestantes > 0) {
                    $estadoNotificacion = $this->getEstadoNotificacion($diasRestantes);
                    $detallesAgrupados[$estadoNotificacion][] = [
                        'placa' => $detalle->vehiculo?->placa ?? 'Sin vehículo',
                        'fecha_vencimiento' => $detalle->fecha,
                    ];
                } elseif ($diasRestantes <= 0) {
                    $detallesAgrupados['VENCIDO'][] = [
                        'placa' => $detalle->vehiculo?->placa ?? 'Sin vehículo',
                        'fecha_vencimiento' => $detalle->fecha,
                    ];
                }
            }

            if (!empty($detallesAgrupados)) {
                $this->enviarNotificacion($cobro, $detallesAgrupados);
            }
        }
    }

    private function getEstadoNotificacion($dias)
    {
        return match ($dias) {
            15 => 'POR VENCER EN 15 DÍAS',
            7  => 'POR VENCER EN 7 DÍAS',
            5  => 'POR VENCER EN 5 DÍAS',
            3  => 'POR VENCER EN 3 DÍAS',
            1  => 'POR VENCER EN 1 DÍA',
            default => 'POR VENCER',
        };
    }

    private function enviarNotificacion($cobro, $detallesAgrupados)
    {
        $users = User::role('admin')->get();

        $mensaje = [
            'body' => "Listado de vehículos con cobros próximos a vencer para el cobro #{$cobro->id}.",
            'asunto' => "NOTIFICACIÓN DE DETALLES DE COBROS (Cobro #{$cobro->id})",
            'estado' => "Cobros por vencer",
            'accion' => 'notification_detalle_cobro',
            'url' => "admin.cobros.show",
            'id_cobro' => $cobro->id,
            'detalles' => $detallesAgrupados,
        ];

        Notification::send($users, new EnviarMensajeCobro($mensaje));
    }
}

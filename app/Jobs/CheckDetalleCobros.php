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
    protected $timeout = 600;
    protected $adminEmail = 'administracion@talentustechnology.com';

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $hoy = Carbon::now()->format('Y-m-d');
        $cobrosConsolidados = [];

        // Buscar todos los cobros que tienen detalles con estado = 1 y fechas en el rango de notificación
        $cobrosConDetalles = Cobros::whereHas('detalle', function ($query) use ($hoy) {
            $query->where('estado', 1) // Solo detalles activos
                ->whereIn('fecha', array_map(fn($dias) => Carbon::now()->addDays($dias)->format('Y-m-d'), $this->notificaciones))
                ->orWhere('fecha', '<', $hoy); // Para detectar los vencidos
        })->with(['detalle' => function ($query) use ($hoy) {
            $query->where('estado', 1) // Solo detalles activos
                ->whereIn('fecha', array_map(fn($dias) => Carbon::now()->addDays($dias)->format('Y-m-d'), $this->notificaciones))
                ->orWhere('fecha', '<', $hoy); // Para detectar los vencidos
        }, 'detalle.vehiculo'])
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
                        'cobro_id' => $cobro->id,
                    ];
                } elseif ($diasRestantes <= 0) {
                    $detallesAgrupados['VENCIDO'][] = [
                        'placa' => $detalle->vehiculo?->placa ?? 'Sin vehículo',
                        'fecha_vencimiento' => $detalle->fecha,
                        'cobro_id' => $cobro->id,
                    ];
                }
            }

            if (!empty($detallesAgrupados)) {
                // Agregar los detalles al arreglo consolidado
                foreach ($detallesAgrupados as $estado => $detalles) {
                    foreach ($detalles as $detalle) {
                        $cobrosConsolidados[$estado][] = $detalle;
                    }
                }
            }
        }

        // Enviar una única notificación con todos los cobros consolidados
        if (!empty($cobrosConsolidados)) {
            $this->enviarNotificacionConsolidada($cobrosConsolidados);
        }
    }

    private function getEstadoNotificacion($dias)
    {
        return match ($dias) {
            15 => 'POR VENCER EN 15 DÍAS',
            7  => 'POR VENCER EN 7 DÍAS',
            5  => 'POR VENCER EN 5 DÍAS',
            4  => 'POR VENCER EN 4 DÍAS',
            3  => 'POR VENCER EN 3 DÍAS',
            1  => 'POR VENCER EN 1 DÍA',
            default => 'POR VENCER',
        };
    }

    private function enviarNotificacionConsolidada($cobrosConsolidados)
    {
        // Buscar o crear un usuario con el correo de administración
        $user = User::firstOrCreate(
            ['email' => $this->adminEmail],
            [
                'name' => 'Administración Talentus',
                'password' => bcrypt(uniqid())
            ]
        );

        $mensaje = [
            'body' => "Listado consolidado de vehículos con cobros próximos a vencer.",
            'asunto' => "NOTIFICACIÓN CONSOLIDADA DE DETALLES DE COBROS - " . Carbon::now()->format('d/m/Y'),
            'estado' => "Cobros por vencer",
            'accion' => 'notification_detalle_cobro',
            'url' => "admin.cobros.index",
            'id_cobro' => 0, // No hay un ID específico para el consolidado
            'detalles' => $cobrosConsolidados,
        ];

        // Enviar notificación solo al usuario de administración
        $user->notify(new EnviarMensajeCobro($mensaje));
    }
}

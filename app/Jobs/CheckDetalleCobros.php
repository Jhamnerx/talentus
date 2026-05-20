<?php

namespace App\Jobs;

use App\Models\Cobros;
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

class CheckDetalleCobros implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $notificaciones = [15, 7, 5, 3, 1];
    protected int $timeout = 600;
    protected array $adminEmails = [
        'administracion@talentustechnology.com',
        'monitoreo@talentustechnology.com',
    ];

    public function handle(): void
    {
        $hoy = Carbon::now();
        $cobrosConsolidados = [];
        $vehiculosOmitidos  = [];

        // Cobros activos con vehÃ­culo activo y fecha_vencimiento en rango de alerta
        $cobros = Cobros::withoutGlobalScope(EmpresaScope::class)
            ->with(['vehiculo'])
            ->where('estado', 'ACTIVO')
            ->whereHas('vehiculo', fn($q) => $q->where('is_active', 1))
            ->where(function ($q) use ($hoy) {
                $fechas = array_map(fn($d) => $hoy->copy()->addDays($d)->format('Y-m-d'), $this->notificaciones);
                $q->whereIn('fecha_vencimiento', $fechas)
                  ->orWhere('fecha_vencimiento', '<', $hoy->format('Y-m-d'));
            })
            ->get();

        foreach ($cobros as $cobro) {
            if (!$cobro->vehiculo || $cobro->vehiculo->is_active != 1) {
                $vehiculosOmitidos[] = [
                    'cobro_id' => $cobro->id,
                    'placa'    => $cobro->vehiculo?->placa ?? 'Sin vehÃ­culo',
                ];
                continue;
            }

            $diasRestantes = $hoy->floatDiffInDays($cobro->fecha_vencimiento, false);

            if ($diasRestantes <= 15 && $diasRestantes > 0) {
                $estado = $this->getEstadoNotificacion((int) $diasRestantes);
            } elseif ($diasRestantes <= 0) {
                $estado = 'VENCIDO';
            } else {
                continue;
            }

            $cobrosConsolidados[$estado][] = [
                'placa'             => $cobro->vehiculo->placa,
                'fecha_vencimiento' => $cobro->fecha_vencimiento?->format('Y-m-d'),
                'cobro_id'          => $cobro->id,
            ];
        }

        if (!empty($vehiculosOmitidos)) {
            Log::info('VehÃ­culos omitidos en CheckDetalleCobros por estar inactivos:', $vehiculosOmitidos);
        }

        if (!empty($cobrosConsolidados)) {
            $this->enviarNotificacionConsolidada($cobrosConsolidados);
        }
    }

    private function getEstadoNotificacion(int $dias): string
    {
        return match ($dias) {
            15      => 'POR VENCER EN 15 DÃAS',
            7       => 'POR VENCER EN 7 DÃAS',
            5       => 'POR VENCER EN 5 DÃAS',
            4       => 'POR VENCER EN 4 DÃAS',
            3       => 'POR VENCER EN 3 DÃAS',
            1       => 'POR VENCER EN 1 DÃA',
            default => 'POR VENCER',
        };
    }

    private function enviarNotificacionConsolidada(array $cobrosConsolidados): void
    {
        $mensaje = [
            'body'    => "Listado consolidado de vehÃ­culos con cobros prÃ³ximos a vencer.",
            'asunto'  => "NOTIFICACIÃ“N CONSOLIDADA DE COBROS - " . Carbon::now()->format('d/m/Y'),
            'estado'  => "Cobros por vencer",
            'accion'  => 'notification_detalle_cobro',
            'url'     => "admin.cobros.index",
            'id_cobro' => 0,
            'detalles' => $cobrosConsolidados,
        ];

        foreach ($this->adminEmails as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->notify(new EnviarMensajeCobro($mensaje));
            } else {
                Log::warning("Usuario no encontrado para notificaciÃ³n de cobros: {$email}");
            }
        }
    }
}

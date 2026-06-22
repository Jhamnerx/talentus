<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WhatsFleep\Device;
use App\Scopes\EmpresaScope;
use App\Services\WhatsFleep\WhatsappService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EnviarResumenDiarioPostventaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(WhatsappService $whatsapp): void
    {
        $ayer = Carbon::yesterday();

        $ordenes = WorkOrder::withoutGlobalScopes()
            ->with(['vehiculo', 'cliente.contactos'])
            ->where('bloqueado', true)
            ->whereBetween('fecha_cerrado', [
                $ayer->copy()->startOfDay(),
                $ayer->copy()->endOfDay(),
            ])
            ->get();

        if ($ordenes->isEmpty()) {
            return;
        }

        $porEmpresa = $ordenes->groupBy('empresa_id');

        foreach ($porEmpresa as $empresaId => $otEmpresa) {
            $device = Device::whereHas('user', function ($query) use ($empresaId) {
                $query->where('empresa_id', $empresaId);
            })->where('interno', true)->first();

            if (!$device) {
                Log::warning('EnviarResumenDiarioPostventaJob: no hay device interno', [
                    'empresa_id' => $empresaId,
                ]);
                continue;
            }

            $usuarios = User::withoutGlobalScope(EmpresaScope::class)
                ->where('empresa_id', $empresaId)
                ->whereNotNull('telefono')
                ->where('telefono', '!=', '')
                ->role(['postventa', 'ventas'])
                ->get();

            if ($usuarios->isEmpty()) {
                continue;
            }

            $mensaje = $this->construirResumen($ayer, $otEmpresa);

            foreach ($usuarios as $usuario) {
                $whatsapp->sendText($device->body, $usuario->telefono, $mensaje);
            }
        }
    }

    private function construirResumen(Carbon $fecha, \Illuminate\Support\Collection $ordenes): string
    {
        $total = $ordenes->count();
        $lineas = ["📋 RESUMEN POST-VENTA | {$fecha->format('d/m/Y')}", "OTs cerradas: {$total}", ''];

        foreach ($ordenes->values() as $i => $ot) {
            $num            = $i + 1;
            $placa          = $ot->vehiculo?->placa ?? 'S/N';
            $cliente        = $ot->cliente?->razon_social ?? 'S/N';
            $primerContacto = $ot->cliente?->contactos?->first();
            $contacto       = $primerContacto?->nombre ?? '';
            $telefono       = $primerContacto?->telefono ?? '';
            $inicio   = $ot->fecha_inicio?->format('d/m/Y') ?? '—';
            $cierre   = $ot->fecha_cerrado?->format('d/m/Y') ?? '—';

            $lineas[] = "{$num}. 🚗 {$placa} — {$cliente}";
            if ($contacto) {
                $lineas[] = "   👤 {$contacto}" . ($telefono ? " | {$telefono}" : '');
            }
            $lineas[] = "   📅 Instalación: {$inicio} | Cierre: {$cierre}";
            $lineas[] = '';
        }

        $lineas[] = 'Enviado por el sistema Talentus';

        return implode("\n", $lineas);
    }
}

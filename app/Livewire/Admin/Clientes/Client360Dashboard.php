<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Clientes;
use App\Models\User;
use App\Services\Gpswox\GpswoxService;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Client360Dashboard extends Component
{
    public Clientes $cliente;

    public function render()
    {
        $this->cliente->loadMissing([
            'vehiculos',
            'contratos',
        ]);

        return view('livewire.admin.clientes.client360-dashboard', [
            'ejecutivo' => $this->ejecutivoAsignado(),
            'vehiculosConGps' => $this->vehiculosConEstadoGps(),
            'certificados' => $this->cliente->certificados()->latest('fecha_instalacion')->limit(20)->get(),
            'actas' => $this->cliente->actas()->latest('fecha_instalacion')->limit(20)->get(),
            'certVelocimetros' => $this->cliente->certVelocimetros()->limit(20)->get(),
            'contratos' => $this->cliente->contratos,
            'resumenComercial' => $this->resumenComercial(),
            'timeline' => $this->timeline(),
        ]);
    }

    private function ejecutivoAsignado(): ?User
    {
        if (! $this->cliente->user_id) {
            return null;
        }

        return User::find($this->cliente->user_id);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function vehiculosConEstadoGps(): array
    {
        $vehiculos = $this->cliente->vehiculos;

        $gpswoxIds = $vehiculos->pluck('gpswox_id')->filter()->values()->all();

        $estados = app(GpswoxService::class)->getLatestStatusForDevices($this->cliente->id, $gpswoxIds);

        return $vehiculos->map(function ($vehiculo) use ($estados) {
            $estado = $estados[(string) $vehiculo->gpswox_id] ?? null;

            return [
                'vehiculo' => $vehiculo,
                'online' => $estado['online'] ?? null,
                'speed' => $estado['speed'] ?? null,
                'time' => $estado['time'] ?? null,
            ];
        })->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function resumenComercial(): array
    {
        $totalFacturado = (float) $this->cliente->ventas()->sum('total');
        $totalPagado = (float) $this->cliente->ventas()->paid()->sum('total');
        $deudaPendiente = (float) $this->cliente->ventas()->unPaid()->sum('total');
        $cantidadVentas = $this->cliente->ventas()->count();
        $ultimaVenta = $this->cliente->ventas()->latest('fecha_emision')->first();

        return [
            'total_facturado' => $totalFacturado,
            'total_pagado' => $totalPagado,
            'deuda_pendiente' => $deudaPendiente,
            'ticket_promedio' => $cantidadVentas > 0 ? $totalFacturado / $cantidadVentas : 0.0,
            'ultima_venta' => $ultimaVenta,
            'cobros_activos' => $this->cliente->cobros()->count(),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection<int, Activity>
     */
    private function timeline()
    {
        $vehiculoIds = $this->cliente->vehiculos->pluck('id')->all();
        $contratoIds = $this->cliente->contratos->pluck('id')->all();

        return Activity::query()
            ->where(function ($query) use ($vehiculoIds, $contratoIds) {
                $query->where(function ($q) {
                    $q->where('subject_type', Clientes::class)
                        ->where('subject_id', $this->cliente->id);
                });

                if (! empty($vehiculoIds)) {
                    $query->orWhere(function ($q) use ($vehiculoIds) {
                        $q->where('subject_type', \App\Models\Vehiculos::class)
                            ->whereIn('subject_id', $vehiculoIds);
                    });
                }

                if (! empty($contratoIds)) {
                    $query->orWhere(function ($q) use ($contratoIds) {
                        $q->where('subject_type', \App\Models\Contratos::class)
                            ->whereIn('subject_id', $contratoIds);
                    });
                }
            })
            ->latest()
            ->limit(50)
            ->get();
    }
}

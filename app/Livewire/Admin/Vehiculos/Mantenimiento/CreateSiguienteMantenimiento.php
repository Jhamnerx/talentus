<?php

namespace App\Livewire\Admin\Vehiculos\Mantenimiento;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Mantenimiento;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class CreateSiguienteMantenimiento extends Component
{
    public bool $modalOpen = false;

    public ?int $mantenimiento_origen_id = null;
    public ?int $vehiculo_id = null;

    #[Validate('required|date')]
    public string $fecha_hora_mantenimiento = '';

    #[Validate('nullable|string')]
    public ?string $detalle_trabajo = null;

    #[Validate('nullable|string')]
    public ?string $nota = null;

    #[Validate('boolean')]
    public bool $notify_admin = true;

    #[Validate('boolean')]
    public bool $notify_client = false;

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.vehiculos.mantenimiento.create-siguiente-mantenimiento');
    }

    #[On('open-siguiente-mantenimiento')]
    public function abrirDesdeCompletado(int $mantenimientoId): void
    {
        $origen = Mantenimiento::find($mantenimientoId);
        if (!$origen) {
            return;
        }

        $this->mantenimiento_origen_id  = $origen->id;
        $this->vehiculo_id              = $origen->vehiculo_id;
        $this->detalle_trabajo          = $origen->detalle_trabajo;
        $this->nota                     = $origen->nota;
        $this->notify_admin             = (bool) $origen->notify_admin;
        $this->notify_client            = (bool) $origen->notify_client;
        $this->fecha_hora_mantenimiento = $origen->fecha_hora_mantenimiento->addYear()->format('Y-m-d');
        $this->modalOpen                = true;
    }

    public function guardar(): void
    {
        $this->validate();

        $mantenimiento = DB::transaction(function () {
            return Mantenimiento::create([
                'numero'                    => $this->generarNumeroSeguro(),
                'vehiculo_id'               => $this->vehiculo_id,
                'detalle_trabajo'           => $this->detalle_trabajo,
                'nota'                      => $this->nota,
                'fecha_hora_mantenimiento'  => $this->fecha_hora_mantenimiento,
                'notify_admin'              => $this->notify_admin,
                'notify_client'             => $this->notify_client,
                'estado'                    => 'PENDIENTE',
            ]);
        });

        $this->dispatch('notify-toast',
            icon: 'success',
            title: 'SIGUIENTE MANTENIMIENTO CREADO',
            mensaje: 'Se registró el mantenimiento <b>' . $mantenimiento->numero . '</b> para el próximo servicio.',
        );

        $this->dispatch('update-table');
        $this->cerrar();
    }

    public function cerrar(): void
    {
        $this->modalOpen = false;
        $this->reset(['mantenimiento_origen_id', 'vehiculo_id', 'detalle_trabajo', 'nota', 'fecha_hora_mantenimiento']);
        $this->notify_admin  = true;
        $this->notify_client = false;
        $this->resetErrorBag();
    }

    private function generarNumeroSeguro(): string
    {
        $anio    = now()->year;
        $prefijo = "MT{$anio}-";
        $pos     = strlen($prefijo) + 1;

        $ultimo = Mantenimiento::where('numero', 'like', $prefijo . '%')
            ->lockForUpdate()
            ->orderByRaw("CAST(SUBSTRING(numero, {$pos}) AS UNSIGNED) DESC")
            ->value('numero');

        $siguiente = $ultimo
            ? (int) substr($ultimo, strlen($prefijo)) + 1
            : 1;

        return $prefijo . str_pad($siguiente, 4, '0', STR_PAD_LEFT);
    }
}

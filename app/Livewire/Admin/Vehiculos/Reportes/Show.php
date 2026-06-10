<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Models\DetalleReportes;
use App\Models\Reportes;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Show extends Component
{
    public Reportes $reporte;

    #[Validate('required|string|min:3', message: 'Escribe al menos 3 caracteres.')]
    public string $nuevoDetalle = '';

    public function mount(): void
    {
        $this->reporte->load([
            'vehiculos.cliente',
            'vehiculos.dispositivoPrincipal.dispositivo.modelo',
            'user',
            'atendidoPor',
            'detalle.user',
        ]);
    }

    public function guardarDetalle(): void
    {
        $this->validate();

        DetalleReportes::create([
            'reportes_id' => $this->reporte->id,
            'detalle'     => $this->nuevoDetalle,
            'user_id'     => Auth::id(),
        ]);

        $this->nuevoDetalle = '';
        $this->reporte->load('detalle.user');

        $this->dispatch('notify-toast', icon: 'success', title: 'Nota guardada', mensaje: 'La nota fue registrada correctamente.');
    }

    public function atender(): void
    {
        $this->reporte->update([
            'estado'       => Reportes::ESTADO_EN_ATENCION,
            'atendido_por' => Auth::id(),
            'atendido_at'  => now(),
        ]);

        $this->addLog('🔵 Alerta tomada por ' . Auth::user()->name);
        $this->reporte->refresh()->load(['user', 'atendidoPor', 'detalle.user']);
    }

    public function cerrar(): void
    {
        $this->reporte->update([
            'estado'     => Reportes::ESTADO_CERRADA,
            'cerrado_at' => now(),
        ]);

        $this->addLog('✅ Alerta cerrada por ' . Auth::user()->name);
        $this->reporte->refresh()->load(['user', 'atendidoPor', 'detalle.user']);
    }

    public function reabrir(): void
    {
        $this->reporte->update([
            'estado'       => Reportes::ESTADO_ABIERTA,
            'atendido_por' => null,
            'atendido_at'  => null,
            'cerrado_at'   => null,
        ]);

        $this->reporte->refresh()->load(['user', 'atendidoPor', 'detalle.user']);
    }

    private function addLog(string $texto): void
    {
        DetalleReportes::create([
            'reportes_id' => $this->reporte->id,
            'detalle'     => $texto,
            'user_id'     => Auth::id(),
        ]);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.vehiculos.reportes.show');
    }
}

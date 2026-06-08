<?php

namespace App\Livewire\Admin\Ventas\Recibos;

use App\Models\Dispositivos;
use App\Models\PeriodoCobro;
use App\Models\Productos;
use App\Models\Recibos;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class EliminarRecibo extends Component
{
    public Model $recibo;
    public $mostrarModal = false;

    // Datos para mostrar en el modal de confirmación
    public array $pagosAsociados  = [];
    public ?array $notificacion   = null;

    protected $listeners = [
        'openModalDelete' => 'abrirModal'
    ];

    public function abrirModal(Recibos $recibo)
    {
        $this->recibo = $recibo;

        // Cargar pagos vigentes asociados al recibo
        $this->pagosAsociados = $recibo->payments()
            ->with('paymentMethod')
            ->get()
            ->map(fn($p) => [
                'numero'  => $p->numero,
                'monto'   => number_format($p->monto, 2),
                'divisa'  => $p->divisa ?? 'PEN',
                'metodo'  => $p->paymentMethod?->nombre ?? '-',
                'fecha'   => optional($p->fecha)->format('d/m/Y') ?? '-',
            ])
            ->toArray();

        // Cargar período de cobro vinculado (si existe)
        $periodo = PeriodoCobro::where('recibo_id', $recibo->id)->first();
        $this->notificacion = $periodo
            ? [
                'id'           => $periodo->id,
                'descripcion'  => $periodo->observaciones ?? ('Período ' . strtolower($periodo->periodo)),
                'monto'        => number_format($periodo->monto, 2),
                'moneda'       => $periodo->divisa,
                'vencimiento'  => $periodo->fecha_fin?->format('d/m/Y') ?? '-',
            ]
            : null;

        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal  = false;
        $this->pagosAsociados = [];
        $this->notificacion  = null;
    }

    public function eliminar()
    {
        // Revertir dispositivos GPS a STOCK
        $dispositivosIds = $this->recibo->detalles()
            ->whereNotNull('imeis')
            ->get()
            ->flatMap(fn($d) => $d->imeis ?? [])
            ->filter()->unique()->values();

        if ($dispositivosIds->isNotEmpty()) {
            Dispositivos::whereIn('id', $dispositivosIds)->update(['estado' => Dispositivos::STOCK]);
        }

        // Restaurar stock de productos físicos del recibo
        foreach ($this->recibo->detalles as $detalle) {
            if ($detalle->producto_id && $detalle->producto?->tipo === 'producto') {
                Productos::where('id', $detalle->producto_id)->increment('stock', $detalle->cantidad);
            }
        }

        // Revertir PeriodosCobro vinculados al recibo
        PeriodoCobro::where('recibo_id', $this->recibo->id)
            ->each(fn($p) => $p->resetFacturacion());

        // Soft-delete de los pagos asociados
        $this->recibo->payments()->delete();

        $this->recibo->delete();
        $this->dispatch('recibo-delete');
        $this->cerrarModal();
    }

    public function render()
    {
        return view('livewire.admin.ventas.recibos.eliminar-recibo');
    }
}

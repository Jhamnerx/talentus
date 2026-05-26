<?php

namespace App\Livewire\Admin\Inicio;

use Carbon\Carbon;
use App\Models\Ventas;
use App\Models\Recibos;
use App\Models\Compras;
use App\Models\Payments;
use Livewire\Component;
use App\Models\ExpensePayment;

class Dashboard extends Component
{
    public string $fechaInicio = '';
    public string $fechaFin    = '';

    protected $listeners = [
        'dashboard-filtro-actualizado' => 'actualizarFiltro',
    ];

    public function mount(): void
    {
        $this->fechaInicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fechaFin    = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function actualizarFiltro(string $fechaInicio, string $fechaFin): void
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin    = $fechaFin;
    }


    public function render()
    {
        $inicio = Carbon::parse($this->fechaInicio)->startOfDay();
        $fin    = Carbon::parse($this->fechaFin)->endOfDay();

        // Ventas activas: excluye borradores, anuladas (id_baja) y con nota de crédito
        $ventasPen = Ventas::whereBetween('fecha_emision', [$inicio, $fin])
            ->where('estado', '!=', 'BORRADOR')
            ->whereNull('id_baja')
            ->whereDoesntHave('notaCredito')
            ->where('divisa', 'PEN')
            ->sum('total');

        $ventasUsd = Ventas::whereBetween('fecha_emision', [$inicio, $fin])
            ->where('estado', '!=', 'BORRADOR')
            ->whereNull('id_baja')
            ->whereDoesntHave('notaCredito')
            ->where('divisa', 'USD')
            ->sum('total');

        // Recibos
        $recibosPen = Recibos::whereBetween('fecha_emision', [$inicio, $fin])
            ->where('divisa', 'PEN')
            ->where('estado', Recibos::COMPLETADO)
            ->whereNull('deleted_at')
            ->sum('total');

        $recibosUsd = Recibos::whereBetween('fecha_emision', [$inicio, $fin])
            ->where('divisa', 'USD')
            ->where('estado', Recibos::COMPLETADO)
            ->whereNull('deleted_at')
            ->sum('total');

        // Compras
        $totalCompras = Compras::whereBetween('fecha_emision', [$inicio, $fin])
            ->whereNull('deleted_at')
            ->sum('total');

        // Ingresos (Payments tipo INGRESO)
        $totalIngresos = Payments::whereBetween('fecha', [$inicio, $fin])
            ->where('type_movement', 'INGRESO')
            ->whereNull('deleted_at')
            ->sum('monto');

        // Egresos (Payments tipo EGRESO + ExpensePayments)
        $totalEgresos = Payments::whereBetween('fecha', [$inicio, $fin])
            ->where('type_movement', 'EGRESO')
            ->whereNull('deleted_at')
            ->sum('monto');

        $totalEgresosCompras = ExpensePayment::whereBetween('date_of_payment', [$inicio, $fin])
            ->sum('payment');

        $resumen = [
            'ventas_pen'     => $ventasPen,
            'ventas_usd'     => $ventasUsd,
            'recibos_pen'    => $recibosPen,
            'recibos_usd'    => $recibosUsd,
            'compras'        => $totalCompras,
            'ingresos'       => $totalIngresos,
            'egresos'        => $totalEgresos + $totalEgresosCompras,
        ];

        return view('livewire.admin.inicio.dashboard', compact('resumen'));
    }
}

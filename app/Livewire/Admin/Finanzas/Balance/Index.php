<?php

namespace App\Livewire\Admin\Finanzas\Balance;

use App\Models\Cash;
use App\Models\Ventas;
use App\Models\Compras;
use App\Models\Recibos;
use Livewire\Component;
use App\Models\Payments;

class Index extends Component
{
    public $from;
    public $to;

    public function mount()
    {
        // Mes actual completo por defecto (del 01 al último día del mes)
        $this->from = date('Y-m-01');
        $this->to = date('Y-m-t'); // Último día del mes actual
    }

    public function render()
    {
        // ── Cajas abiertas ──────────────────────────────────────────────────
        $cajasAbiertas      = Cash::abierta()->get();
        $saldoTotalCajasPen = $cajasAbiertas->sum('saldo_actual_pen');
        $saldoTotalCajasUsd = $cajasAbiertas->sum('saldo_actual_usd');

        // ── Movimientos del período (campo fecha del pago) ──────────────────
        $movimientos = Payments::whereBetween('fecha', [$this->from, $this->to])->get();
        $ingresosPen = $movimientos->where('type_movement', 'INGRESO')->where('divisa', 'PEN')->sum('monto');
        $ingresosUsd = $movimientos->where('type_movement', 'INGRESO')->where('divisa', 'USD')->sum('monto');
        $egresosPen  = $movimientos->where('type_movement', 'EGRESO')->where('divisa', 'PEN')->sum('monto');
        $egresosUsd  = $movimientos->where('type_movement', 'EGRESO')->where('divisa', 'USD')->sum('monto');
        $balancePen  = $ingresosPen - $egresosPen;
        $balanceUsd  = $ingresosUsd - $egresosUsd;

        // ── Facturado y pagado en el período ────────────────────────────────
        $ventasPagadas = Ventas::where('pago_estado', 'PAID')
            ->whereBetween('fecha_emision', [$this->from, $this->to])
            ->get();
        $recibosPagados = Recibos::where('pago_estado', 'PAID')
            ->whereBetween('fecha_emision', [$this->from, $this->to])
            ->get();
        $facturadoYPagadoPen = $ventasPagadas->where('divisa', 'PEN')->sum('total')
            + $recibosPagados->where('divisa', 'PEN')->sum('total');
        $facturadoYPagadoUsd = $ventasPagadas->where('divisa', 'USD')->sum('total')
            + $recibosPagados->where('divisa', 'USD')->sum('total');
        $documentosPagados   = $ventasPagadas->count() + $recibosPagados->count();

        // Closure reutilizable: saldo pendiente real de un documento
        $saldo = fn($doc) => max(0, $doc->total - $doc->payments->sum('monto'));

        // ── Facturado pendiente en el período ───────────────────────────────
        // Ventas: excluye las con NC (comprobantes) y las comunicadas de baja (id_baja)
        $ventasPendientes = Ventas::where('pago_estado', 'UNPAID')
            ->whereNull('id_baja')
            ->whereDoesntHave('notaCredito')
            ->whereBetween('fecha_emision', [$this->from, $this->to])
            ->with('payments')
            ->get();
        $recibosPendientes = Recibos::where('pago_estado', 'UNPAID')
            ->whereBetween('fecha_emision', [$this->from, $this->to])
            ->with('payments')
            ->get();
        $facturadoPendientePen = $ventasPendientes->where('divisa', 'PEN')->sum($saldo)
            + $recibosPendientes->where('divisa', 'PEN')->sum($saldo);
        $facturadoPendienteUsd = $ventasPendientes->where('divisa', 'USD')->sum($saldo)
            + $recibosPendientes->where('divisa', 'USD')->sum($saldo);
        $documentosPendientes  = $ventasPendientes->count() + $recibosPendientes->count();

        // ── Cuentas por cobrar — total sin filtro de fechas ─────────────────
        $todasVentasPendientes = Ventas::where('pago_estado', 'UNPAID')
            ->whereNull('id_baja')
            ->whereDoesntHave('notaCredito')
            ->with('payments')
            ->get();
        $todosRecibosPendientes = Recibos::where('pago_estado', 'UNPAID')
            ->with('payments')
            ->get();
        $totalPorCobrarPen = $todasVentasPendientes->where('divisa', 'PEN')->sum($saldo)
            + $todosRecibosPendientes->where('divisa', 'PEN')->sum($saldo);
        $totalPorCobrarUsd = $todasVentasPendientes->where('divisa', 'USD')->sum($saldo)
            + $todosRecibosPendientes->where('divisa', 'USD')->sum($saldo);
        $cuentasVencidas = $todasVentasPendientes->filter(fn($v) => $v->fecha_vencimiento?->isPast())->count()
            + $todosRecibosPendientes->filter(fn($r) => $r->fecha_vencimiento?->isPast())->count();

        // ── Cuentas por pagar — total sin filtro de fechas ──────────────────
        $comprasPendientes       = Compras::where('pago_estado', 'UNPAID')->with('payments')->get();
        $totalPorPagarPen        = $comprasPendientes->where('divisa', 'PEN')->sum($saldo);
        $totalPorPagarUsd        = $comprasPendientes->where('divisa', 'USD')->sum($saldo);
        $cuentasPorPagarVencidas = $comprasPendientes->filter(fn($c) => $c->fecha_vencimiento?->isPast())->count();

        // ── Liquidez neta por divisa ─────────────────────────────────────────
        $liquidezNetaPen = $saldoTotalCajasPen + $totalPorCobrarPen - $totalPorPagarPen;
        $liquidezNetaUsd = $saldoTotalCajasUsd + $totalPorCobrarUsd - $totalPorPagarUsd;

        return view('livewire.admin.finanzas.balance.index', compact(
            'saldoTotalCajasPen',
            'saldoTotalCajasUsd',
            'ingresosPen',
            'ingresosUsd',
            'egresosPen',
            'egresosUsd',
            'balancePen',
            'balanceUsd',
            'facturadoYPagadoPen',
            'facturadoYPagadoUsd',
            'documentosPagados',
            'facturadoPendientePen',
            'facturadoPendienteUsd',
            'documentosPendientes',
            'totalPorCobrarPen',
            'totalPorCobrarUsd',
            'cuentasVencidas',
            'totalPorPagarPen',
            'totalPorPagarUsd',
            'cuentasPorPagarVencidas',
            'liquidezNetaPen',
            'liquidezNetaUsd',
        ));
    }

    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime('-7 days'));
                $this->to = date('Y-m-d');
                break;
            case '30':
                // Este Mes: del 01 hasta el último día del mes actual
                $this->from = date('Y-m-01'); // Primer día del mes
                $this->to = date('Y-m-t'); // Último día del mes
                break;
            case 'last_month':
                // Mes Pasado: del 01 hasta el último día del mes anterior
                $this->from = date('Y-m-01', strtotime('first day of last month'));
                $this->to = date('Y-m-t', strtotime('last day of last month'));
                break;
            case '90':
                $this->from = date('Y-m-d', strtotime('-3 months'));
                $this->to = date('Y-m-d');
                break;
        }
    }
}

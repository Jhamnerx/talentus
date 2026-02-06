<?php

namespace App\Livewire\Admin\Finanzas\Balance;

use App\Models\Cash;
use App\Models\Ventas;
use App\Models\Compras;
use Livewire\Component;
use App\Models\GlobalPayment;

class Index extends Component
{
    public $from;
    public $to;

    public function mount()
    {
        // Mes actual por defecto
        $this->from = date('Y-m-01');
        $this->to = date('Y-m-d');
    }

    public function render()
    {
        // Saldo total en cajas abiertas
        $saldoTotalCajas = Cash::abierta()->sum('saldo_actual');

        // Movimientos en el período seleccionado usando GlobalPayment
        // Como type_movement y monto son accessors, debemos cargar todos y filtrar en memoria
        $movimientos = GlobalPayment::with(['payment.paymentable'])
            ->whereBetween('created_at', [$this->from . ' 00:00:00', $this->to . ' 23:59:59'])
            ->get();

        $ingresos = $movimientos->filter(function ($gp) {
            return $gp->type_movement === 'INGRESO';
        })->sum('monto');

        $egresos = $movimientos->filter(function ($gp) {
            return $gp->type_movement === 'EGRESO';
        })->sum('monto');

        $balance = $ingresos - $egresos;

        // ========== CUENTAS POR COBRAR ==========
        // Obtiene todas las ventas que no están completamente pagadas (UNPAID o PARTIAL)
        // y calcula cuánto falta por cobrar de cada una
        $ventasPendientes = Ventas::whereIn('pago_estado', ['UNPAID', 'PARTIAL'])
            ->with('payments')
            ->get();

        $totalPorCobrar = $ventasPendientes->sum(function ($venta) {
            // Total de la venta menos lo que ya se pagó
            $pagado = $venta->payments->sum('monto');
            return max(0, $venta->total - $pagado);
        });

        $cuentasVencidas = $ventasPendientes->filter(function ($venta) {
            return $venta->fecha_vencimiento && $venta->fecha_vencimiento->isPast();
        })->count();

        // ========== CUENTAS POR PAGAR ==========
        // Obtiene todas las compras que no están completamente pagadas (UNPAID o PARTIAL)
        // y calcula cuánto falta por pagar de cada una
        $comprasPendientes = Compras::whereIn('pago_estado', ['UNPAID', 'PARTIAL'])
            ->with('payments')
            ->get();

        $totalPorPagar = $comprasPendientes->sum(function ($compra) {
            // Total de la compra menos lo que ya se pagó
            $pagado = $compra->payments->sum('monto');
            return max(0, $compra->total - $pagado);
        });

        $cuentasPorPagarVencidas = $comprasPendientes->filter(function ($compra) {
            return $compra->fecha_vencimiento && $compra->fecha_vencimiento->isPast();
        })->count();

        // ========== LIQUIDEZ NETA ==========
        // Fórmula: Dinero disponible en cajas + Dinero que me deben - Dinero que debo
        // Representa el capital real disponible si se cobrara todo y se pagara todo
        $liquidezNeta = $saldoTotalCajas + $totalPorCobrar - $totalPorPagar;

        return view('livewire.admin.finanzas.balance.index', compact(
            'saldoTotalCajas',
            'ingresos',
            'egresos',
            'balance',
            'totalPorCobrar',
            'cuentasVencidas',
            'totalPorPagar',
            'cuentasPorPagarVencidas',
            'liquidezNeta'
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
                $this->from = date('Y-m-d', strtotime('-1 month'));
                $this->to = date('Y-m-d');
                break;
            case '90':
                $this->from = date('Y-m-d', strtotime('-3 months'));
                $this->to = date('Y-m-d');
                break;
        }
    }
}

<?php

namespace App\Livewire\Admin\Finanzas\Balance;

use App\Models\Cash;
use App\Models\Ventas;
use App\Models\Compras;
use App\Models\Recibos;
use Livewire\Component;
use App\Models\Payments;
use App\Models\DetalleCobros;
use App\Enums\EstadoFacturacion;
use App\Enums\CobroEstado;

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
        // Saldo total en cajas abiertas (multi-moneda)
        $cajasAbiertas = Cash::abierta()->get();
        $saldoTotalCajasPen = $cajasAbiertas->sum('saldo_actual_pen');
        $saldoTotalCajasUsd = $cajasAbiertas->sum('saldo_actual_usd');
        $saldoTotalCajas = $saldoTotalCajasPen; // Compatibilidad, mostrar PEN por defecto

        // Movimientos en el período seleccionado usando Payments directamente
        $movimientos = Payments::with(['paymentable'])
            ->whereBetween('created_at', [$this->from . ' 00:00:00', $this->to . ' 23:59:59'])
            ->get();

        $ingresos = $movimientos->where('type_movement', 'INGRESO')->sum('monto');
        $egresos = $movimientos->where('type_movement', 'EGRESO')->sum('monto');

        $balance = $ingresos - $egresos;

        // ========== FACTURADO Y PAGADO (en el período) ==========
        // Documentos completamente pagados dentro del rango de fechas
        $ventasPagadas = Ventas::where('pago_estado', 'PAID')
            ->whereBetween('fecha_emision', [$this->from, $this->to])
            ->get();

        $recibosPagados = Recibos::where('pago_estado', 'PAID')
            ->whereBetween('fecha_emision', [$this->from, $this->to])
            ->get();

        $facturadoYPagado = $ventasPagadas->sum('total') + $recibosPagados->sum('total');
        $documentosPagados = $ventasPagadas->count() + $recibosPagados->count();

        // ========== FACTURADO PENDIENTE DE COBRO ==========
        // Ventas y Recibos sin pagar completamente (dentro del rango de fechas de emisión)
        $ventasPendientes = Ventas::whereIn('pago_estado', ['UNPAID', 'PARTIAL'])
            ->whereBetween('fecha_emision', [$this->from, $this->to])
            ->with('payments')
            ->get();

        $recibosPendientes = Recibos::whereIn('pago_estado', ['UNPAID', 'PARTIAL'])
            ->whereBetween('fecha_emision', [$this->from, $this->to])
            ->with('payments')
            ->get();

        $facturadoPendiente = $ventasPendientes->sum(function ($venta) {
            $pagado = $venta->payments->sum('monto');
            return max(0, $venta->total - $pagado);
        }) + $recibosPendientes->sum(function ($recibo) {
            $pagado = $recibo->payments->sum('monto');
            return max(0, $recibo->total - $pagado);
        });

        $documentosPendientes = $ventasPendientes->count() + $recibosPendientes->count();

        // ========== PENDIENTE DE FACTURAR ==========
        // DetalleCobros sin facturar cuya fecha_facturacion está dentro del rango
        $detallesSinFacturar = DetalleCobros::where('estado_facturacion', EstadoFacturacion::SIN_FACTURAR)
            ->where('estado_detalle', CobroEstado::ACTIVO)
            ->where('estado', 1)
            ->whereBetween('fecha_facturacion', [$this->from, $this->to])
            ->with('cobro.clientes', 'vehiculo')
            ->get();

        $pendienteFacturar = $detallesSinFacturar->sum('plan');
        $detallesSinFacturarCount = $detallesSinFacturar->count();

        // ========== CUENTAS POR COBRAR (TOTAL) ==========
        // TODO lo que está pendiente de cobrar sin filtro de fechas
        $todasVentasPendientes = Ventas::whereIn('pago_estado', ['UNPAID', 'PARTIAL'])
            ->with('payments')
            ->get();

        $todosRecibosPendientes = Recibos::whereIn('pago_estado', ['UNPAID', 'PARTIAL'])
            ->with('payments')
            ->get();

        $totalPorCobrar = $todasVentasPendientes->sum(function ($venta) {
            $pagado = $venta->payments->sum('monto');
            return max(0, $venta->total - $pagado);
        }) + $todosRecibosPendientes->sum(function ($recibo) {
            $pagado = $recibo->payments->sum('monto');
            return max(0, $recibo->total - $pagado);
        });

        $cuentasVencidas = $todasVentasPendientes->filter(function ($venta) {
            return $venta->fecha_vencimiento && $venta->fecha_vencimiento->isPast();
        })->count() + $todosRecibosPendientes->filter(function ($recibo) {
            return $recibo->fecha_vencimiento && $recibo->fecha_vencimiento->isPast();
        })->count();

        // ========== CUENTAS POR PAGAR (TOTAL) ==========
        // Todas las compras pendientes sin filtro de fechas
        $comprasPendientes = Compras::whereIn('pago_estado', ['PENDIENTE', 'PARCIAL'])
            ->with('payments')
            ->get();

        $totalPorPagar = $comprasPendientes->sum(function ($compra) {
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
            'saldoTotalCajasPen',
            'saldoTotalCajasUsd',
            'ingresos',
            'egresos',
            'balance',
            'facturadoYPagado',
            'documentosPagados',
            'facturadoPendiente',
            'documentosPendientes',
            'pendienteFacturar',
            'detallesSinFacturarCount',
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

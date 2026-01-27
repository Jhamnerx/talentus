<?php

namespace App\Livewire\Admin\Finanzas\Balance;

use App\Models\Cash;
use App\Models\CashMovement;
use App\Models\AccountReceivable;
use App\Models\AccountPayable;
use Livewire\Component;

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

        // Movimientos en el período seleccionado
        $ingresos = CashMovement::where('tipo', 'INGRESO')
            ->whereBetween('fecha', [$this->from, $this->to])
            ->sum('monto');

        $egresos = CashMovement::where('tipo', 'EGRESO')
            ->whereBetween('fecha', [$this->from, $this->to])
            ->sum('monto');

        $balance = $ingresos - $egresos;

        // Cuentas por cobrar
        $totalPorCobrar = AccountReceivable::whereIn('estado', ['PENDIENTE', 'PARCIAL'])
            ->sum('saldo_pendiente');

        $cuentasVencidas = AccountReceivable::where('estado', 'VENCIDO')
            ->count();

        // Cuentas por pagar
        $totalPorPagar = AccountPayable::whereIn('estado', ['PENDIENTE', 'PARCIAL'])
            ->sum('saldo_pendiente');

        $cuentasPorPagarVencidas = AccountPayable::where('estado', 'VENCIDO')
            ->count();

        // Totales generales
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

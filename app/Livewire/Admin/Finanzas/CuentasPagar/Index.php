<?php

namespace App\Livewire\Admin\Finanzas\CuentasPagar;

use App\Models\AccountPayable;
use App\Models\Proveedores;
use App\Enums\PaymentStatus;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WithPagination, WireUiActions;

    public $search = '';
    public $from = '';
    public $to = '';
    public $estado_filter = '';
    public $proveedor_id = '';
    public $con_mora = false;

    #[On('render')]
    public function render()
    {
        $query = AccountPayable::with(['proveedor'])
            ->where(function ($q) {
                $q->where('numero_documento', 'like', '%' . $this->search . '%')
                    ->orWhereHas('proveedor', function ($query) {
                        $query->where('razon_social', 'like', '%' . $this->search . '%')
                            ->orWhere('numero_documento', 'like', '%' . $this->search . '%');
                    });
            });

        // Filtro por estado
        if ($this->estado_filter) {
            $query->where('estado', $this->estado_filter);
        }

        // Filtro por proveedor
        if ($this->proveedor_id) {
            $query->where('proveedor_id', $this->proveedor_id);
        }

        // Filtro por rango de fechas
        if (!empty($this->from) && !empty($this->to)) {
            $query->whereBetween('fecha_emision', [$this->from, $this->to]);
        }

        // Filtro por cuentas con mora
        if ($this->con_mora) {
            $query->conMora();
        }

        $cuentas = $query->orderBy('fecha_emision', 'desc')->paginate(10);

        // Transformar registros agregando cálculos adicionales
        $cuentas->getCollection()->transform(function ($cuenta) {
            $cuenta->dias_mora = $cuenta->dias_mora;
            $cuenta->esta_vencida = $cuenta->esta_vencida;
            $cuenta->total_pendiente_real = $cuenta->total_pendiente_real;
            return $cuenta;
        });

        $proveedores = Proveedores::orderBy('razon_social')->get();

        // Calcular totales
        $totales = [
            'total_por_pagar' => $query->sum('saldo_pendiente'),
            'total_vencido' => (clone $query)->conMora()->sum('saldo_pendiente'),
            'total_pagado' => AccountPayable::sum('monto_pagado'),
        ];

        return view('livewire.admin.finanzas.cuentas-pagar.index', compact('cuentas', 'totales'));
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
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }
}

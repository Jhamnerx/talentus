<?php

namespace App\Livewire\Admin\Finanzas\CuentasPagar;

use App\Models\Compras;
use App\Models\Proveedores;
use App\Models\Payments;
use Illuminate\Support\Facades\DB;
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
    public $proveedor_id = '';

    public function mount()
    {
        // Recalcular estados al cargar el componente
        $this->recalcularEstados();
    }

    /**
     * Recalcula el estado de pago de todas las compras basándose en los pagos reales
     */
    public function recalcularEstados()
    {
        $compras = Compras::all();
        $actualizadas = 0;

        foreach ($compras as $compra) {
            $totalPagado = Payments::where('paymentable_type', 'App\\Models\\Compras')
                ->where('paymentable_id', $compra->id)
                ->sum('monto');

            $estadoAnterior = $compra->pago_estado;
            $estadoNuevo = null;

            if ($totalPagado >= $compra->total) {
                $estadoNuevo = 'PAID';
            } elseif ($totalPagado > 0) {
                $estadoNuevo = 'PARCIAL';
            } else {
                $estadoNuevo = 'PENDIENTE';
            }

            if ($estadoAnterior !== $estadoNuevo) {
                $compra->update(['pago_estado' => $estadoNuevo]);
                $actualizadas++;
            }
        }

        if ($actualizadas > 0) {
            $this->notification()->success(
                'Estados actualizados',
                "Se actualizaron {$actualizadas} compras"
            );
        }

        $this->dispatch('render');
    }

    #[On('render')]
    public function render()
    {
        // Query base de Compras con pago_estado != 'PAID'
        $compras = Compras::select(
            'id',
            'proveedor_id',
            'fecha_emision',
            'serie',
            'correlativo',
            'serie_correlativo',
            'total',
            'divisa',
            'pago_estado'
        )
            ->where('pago_estado', '!=', 'PAID')
            ->with('proveedor:id,razon_social,numero_documento');

        // Aplicar filtros
        if ($this->search) {
            $compras->where(function ($q) {
                $q->where('serie_correlativo', 'like', '%' . $this->search . '%')
                    ->orWhere('serie', 'like', '%' . $this->search . '%')
                    ->orWhere('correlativo', 'like', '%' . $this->search . '%')
                    ->orWhereHas('proveedor', function ($query) {
                        $query->where('razon_social', 'like', '%' . $this->search . '%')
                            ->orWhere('numero_documento', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->proveedor_id) {
            $compras->where('proveedor_id', $this->proveedor_id);
        }

        if ($this->from && $this->to) {
            $compras->whereBetween('fecha_emision', [$this->from, $this->to]);
        }

        $documentos = $compras->orderBy('fecha_emision', 'desc')->paginate(10);

        // Calcular total pagado y pendiente por cada documento
        $documentos->getCollection()->transform(function ($doc) {
            $totalPagado = Payments::where('paymentable_type', 'App\\Models\\Compras')
                ->where('paymentable_id', $doc->id)
                ->sum('monto');

            $doc->total_pagado = $totalPagado;
            $doc->total_pendiente = max(0, $doc->total - $totalPagado);

            return $doc;
        });

        $proveedores = Proveedores::orderBy('razon_social')->get();

        // Calcular totales globales
        $totales = $this->calcularTotales();

        return view('livewire.admin.finanzas.cuentas-pagar.index', compact('documentos', 'totales', 'proveedores'));
    }

    protected function calcularTotales()
    {
        $comprasUnpaid = Compras::where('pago_estado', '!=', 'PAID')->get();

        $totalPorPagar = 0;
        $totalPagado = 0;

        foreach ($comprasUnpaid as $compra) {
            $pagado = Payments::where('paymentable_type', 'App\\Models\\Compras')
                ->where('paymentable_id', $compra->id)
                ->sum('monto');
            $totalPagado += $pagado;
            $totalPorPagar += max(0, $compra->total - $pagado);
        }

        return [
            'total_por_pagar' => $totalPorPagar,
            'total_pagado' => $totalPagado,
        ];
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

    /**
     * Abrir modal para registrar pago de una cuenta por pagar
     */
    public function openRegisterPayment($paymentable_id)
    {
        $this->dispatch(
            'open-modal-register-payment-compras',
            paymentable_id: $paymentable_id
        );
    }
}

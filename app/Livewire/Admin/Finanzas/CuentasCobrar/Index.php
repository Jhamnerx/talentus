<?php

namespace App\Livewire\Admin\Finanzas\CuentasCobrar;

use App\Models\Ventas;
use App\Models\Recibos;
use App\Models\Clientes;
use App\Models\Payments;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\DB;

/**
 * Cuentas por Cobrar - Similar a Unpaid de FactuPRO
 * Carga documentos (Ventas/Recibos) con saldo pendiente
 */
class Index extends Component
{
    use WithPagination, WireUiActions;

    public $search = '';
    public $from = '';
    public $to = '';
    public $tipo_documento = ''; // 'ventas' o 'recibos'
    public $cliente_id = '';

    #[On('render')]
    #[On('update-cuentas-cobrar')]
    public function render()
    {
        // Unión de Ventas y Recibos con saldo pendiente (similar a FactuPRO Unpaid)
        $ventas = Ventas::select(
            'id',
            DB::raw("'ventas' as type"),
            'cliente_id',
            'fecha_emision',
            'serie_correlativo as numero_documento',
            'serie',
            'correlativo',
            'total',
            'divisa',
            'pago_estado'
        )
            ->where('pago_estado', '!=', 'PAID');

        $recibos = Recibos::select(
            'id',
            DB::raw("'recibos' as type"),
            'clientes_id as cliente_id',
            'fecha_emision',
            'serie_numero as numero_documento',
            'serie',
            'numero as correlativo',
            'total',
            'divisa',
            'pago_estado'
        )
            ->where('pago_estado', '!=', 'PAID');

        // Aplicar filtros
        if ($this->search) {
            $ventas->where(function ($q) {
                $q->where('serie_correlativo', 'like', '%' . $this->search . '%')
                    ->orWhereHas('cliente', function ($query) {
                        $query->where('razon_social', 'like', '%' . $this->search . '%')
                            ->orWhere('numero_documento', 'like', '%' . $this->search . '%');
                    });
            });
            $recibos->where(function ($q) {
                $q->where('serie_numero', 'like', '%' . $this->search . '%')
                    ->orWhereHas('cliente', function ($query) {
                        $query->where('razon_social', 'like', '%' . $this->search . '%')
                            ->orWhere('numero_documento', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->cliente_id) {
            $ventas->where('cliente_id', $this->cliente_id);
            $recibos->where('clientes_id', $this->cliente_id);
        }

        if ($this->from && $this->to) {
            $ventas->whereBetween('fecha_emision', [$this->from, $this->to]);
            $recibos->whereBetween('fecha_emision', [$this->from, $this->to]);
        }

        if ($this->tipo_documento === 'ventas') {
            $documentos = $ventas->orderBy('fecha_emision', 'desc')->paginate(10);
        } elseif ($this->tipo_documento === 'recibos') {
            $documentos = $recibos->orderBy('fecha_emision', 'desc')->paginate(10);
        } else {
            // Unir ambos (similar a FactuPRO)
            $documentos = $ventas->union($recibos)
                ->orderBy('fecha_emision', 'desc')
                ->paginate(10);
        }

        // Calcular total pagado y pendiente por cada documento
        $documentos->getCollection()->transform(function ($doc) {
            $paymentableType = $doc->type === 'ventas' ? 'App\\Models\\Ventas' : 'App\\Models\\Recibos';

            $totalPagado = Payments::where('paymentable_type', $paymentableType)
                ->where('paymentable_id', $doc->id)
                ->sum('monto');

            $doc->total_pagado = $totalPagado;
            $doc->total_pendiente = max(0, $doc->total - $totalPagado);

            // Cargar cliente manualmente (ya que UNION no soporta eager loading)
            $doc->cliente = Clientes::select('id', 'razon_social', 'numero_documento')
                ->find($doc->cliente_id);

            return $doc;
        });

        $clientes = Clientes::orderBy('razon_social')->get();

        // Calcular totales globales
        $totales = $this->calcularTotales();

        return view('livewire.admin.finanzas.cuentas-cobrar.index', compact('documentos', 'totales', 'clientes'));
    }

    protected function calcularTotales()
    {
        $ventasUnpaid = Ventas::where('pago_estado', '!=', 'PAID')->get();
        $recibosUnpaid = Recibos::where('pago_estado', '!=', 'PAID')->get();

        $totalPorCobrar = 0;
        $totalPagado = 0;

        foreach ($ventasUnpaid as $venta) {
            $pagado = Payments::where('paymentable_type', 'App\\Models\\Ventas')
                ->where('paymentable_id', $venta->id)
                ->sum('monto');
            $totalPagado += $pagado;
            $totalPorCobrar += max(0, $venta->total - $pagado);
        }

        foreach ($recibosUnpaid as $recibo) {
            $pagado = Payments::where('paymentable_type', 'App\\Models\\Recibos')
                ->where('paymentable_id', $recibo->id)
                ->sum('monto');
            $totalPagado += $pagado;
            $totalPorCobrar += max(0, $recibo->total - $pagado);
        }

        return [
            'total_por_cobrar' => $totalPorCobrar,
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
     * Abrir modal para registrar pago de una cuenta por cobrar
     */
    public function openRegisterPayment($paymentable_type, $paymentable_id)
    {
        $this->dispatch(
            'open-modal-register-payment',
            paymentable_type: $paymentable_type,
            paymentable_id: $paymentable_id
        );
    }
}

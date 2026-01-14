<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payments;
use App\Models\PaymentMethodType;
use App\Models\Ventas;
use App\Models\Recibos;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;
use App\Http\Controllers\Admin\PaymentsController;

class Save extends Component
{
    use WireUiActions;

    public $modalSave = false;
    public $numero;
    public $numero_operacion;
    public $fecha;
    public $nota;
    public $documento;
    public $divisa = 'PEN';
    public $monto;
    public $payment_method_id;
    public $cobros_id;
    public $tipo_pago = 'FACTURA';
    public $documentos = [];
    public $titulo_documento = 'Numero Factura o Boleta';
    public $paymentable_type;
    public $paymentable_id;
    public $divisaDoc;
    public $totalDocumento = 0;
    public $pagosPrevios = 0;
    public $saldoPendiente = 0;
    public $marcar_como_pagado = false;

    public function render()
    {
        $paymentMethods = PaymentMethodType::whereActive(true)->orderByDescription()->get();
        return view('livewire.admin.payments.save', compact('paymentMethods'));
    }

    public function updatedTipoPago($tipo_pago)
    {
        $this->reset('paymentable_type', 'paymentable_id', 'divisaDoc', 'monto');

        if ($tipo_pago == "FACTURA") {
            $this->titulo_documento = "Numero Factura o Boleta";
            $this->documentos = $this->loadFacturas();
            $this->paymentable_type = Ventas::class;
        } else {
            $this->titulo_documento = "Numero Recibo";
            $this->documentos = $this->loadRecibos();
            $this->paymentable_type = Recibos::class;
        }
    }

    public function updatedPaymentableId($paymentable_id)
    {
        if ($paymentable_id == null) {
            $this->divisaDoc = null;
            $this->monto = null;
            $this->totalDocumento = 0;
            $this->pagosPrevios = 0;
            $this->saldoPendiente = 0;
            $this->marcar_como_pagado = false;
            return;
        }

        if ($this->paymentable_type == 'App\\Models\\Ventas') {
            $documento = Ventas::find($paymentable_id);
            if ($documento) {
                $this->divisaDoc = $documento->divisa;
                $this->divisa = $documento->divisa;
                $this->totalDocumento = $documento->total;

                // Calcular pagos previos
                $this->pagosPrevios = Payments::where('paymentable_type', 'App\\Models\\Ventas')
                    ->where('paymentable_id', $paymentable_id)
                    ->sum('monto');

                $this->saldoPendiente = $this->totalDocumento - $this->pagosPrevios;
                $this->monto = $this->saldoPendiente;

                // Auto-marcar si el saldo se completa
                $this->marcar_como_pagado = false;
            }
        }

        if ($this->paymentable_type == 'App\\Models\\Recibos') {
            $documento = Recibos::find($paymentable_id);
            if ($documento) {
                $this->divisaDoc = $documento->divisa;
                $this->divisa = $documento->divisa;
                $this->totalDocumento = $documento->total;

                // Calcular pagos previos
                $this->pagosPrevios = Payments::where('paymentable_type', 'App\\Models\\Recibos')
                    ->where('paymentable_id', $paymentable_id)
                    ->sum('monto');

                $this->saldoPendiente = $this->totalDocumento - $this->pagosPrevios;
                $this->monto = $this->saldoPendiente;

                // Auto-marcar si el saldo se completa
                $this->marcar_como_pagado = false;
            }
        }
    }

    public function loadFacturas()
    {
        $data = [];
        $facturas = Ventas::where('pago_estado', 'UNPAID')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($facturas as $invoice) {
            $data[] = [
                'id' => $invoice->id,
                'text' => $invoice->serie_correlativo,
                'fecha_emision' => $invoice->fecha_emision->format('d-m-Y'),
                'monto' => $invoice->total,
                'divisa' => $invoice->divisa,
            ];
        }

        return $data;
    }

    public function loadRecibos()
    {
        $data = [];
        $recibos = Recibos::unpaid()
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($recibos as $recibo) {
            $data[] = [
                'id' => $recibo->id,
                'text' => $recibo->serie_numero,
                'fecha_emision' => $recibo->created_at->format('d-m-Y'),
                'monto' => $recibo->total,
                'divisa' => $recibo->divisa,
            ];
        }

        return $data;
    }

    #[On('open-modal-save')]
    public function openModal()
    {
        $this->resetProp();
        $this->modalSave = true;
        $this->numero = (new PaymentsController())->setNextSequenceNumber();
        $this->fecha = now()->format('Y-m-d');
        $this->tipo_pago = 'FACTURA';
        $this->documentos = $this->loadFacturas();
        $this->paymentable_type = Ventas::class;
    }

    public function closeModal()
    {
        $this->modalSave = false;
        $this->resetProp();
    }

    public function resetProp()
    {
        $this->reset([
            'numero',
            'numero_operacion',
            'fecha',
            'nota',
            'documento',
            'divisa',
            'monto',
            'payment_method_id',
            'cobros_id',
            'tipo_pago',
            'documentos',
            'paymentable_type',
            'paymentable_id',
            'divisaDoc',
            'totalDocumento',
            'pagosPrevios',
            'saldoPendiente',
            'marcar_como_pagado'
        ]);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate([
            'numero' => 'required|string|max:191',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'payment_method_id' => 'required|exists:payment_method_types,id',
            'numero_operacion' => 'nullable|string|max:191',
            'documento' => 'nullable|string|max:191',
            'nota' => 'nullable|string|max:500',
            'divisa' => 'required|in:PEN,USD',
        ], [
            'numero.required' => 'El número es obligatorio',
            'fecha.required' => 'La fecha es obligatoria',
            'monto.required' => 'El monto es obligatorio',
            'monto.numeric' => 'El monto debe ser un valor numérico',
            'payment_method_id.required' => 'Debe seleccionar un método de pago',
        ]);

        try {
            $payment = Payments::create([
                'numero' => $this->numero,
                'numero_operacion' => $this->numero_operacion,
                'fecha' => $this->fecha,
                'nota' => $this->nota,
                'documento' => $this->documento,
                'divisa' => $this->divisa,
                'monto' => $this->monto,
                'payment_method_id' => $this->payment_method_id,
                'cobros_id' => $this->cobros_id,
                'paymentable_type' => $this->paymentable_type,
                'paymentable_id' => $this->paymentable_id,
            ]);

            // Actualizar estado del documento si se marcó como pagado
            if ($this->marcar_como_pagado && $this->paymentable_id) {
                if ($this->paymentable_type == 'App\\Models\\Ventas') {
                    $documento = Ventas::find($this->paymentable_id);
                    if ($documento) {
                        $documento->update([
                            'pago_estado' => 'PAID',
                            'estado' => 'COMPLETADO'
                        ]);
                    }
                } elseif ($this->paymentable_type == 'App\\Models\\Recibos') {
                    $documento = Recibos::find($this->paymentable_id);
                    if ($documento) {
                        $documento->update([
                            'pago_estado' => 'PAID',
                            'estado' => 'COMPLETADO'
                        ]);
                    }
                }
            }

            $this->closeModal();
            $this->notification()->success('Pago guardado', 'El pago fue registrado correctamente');
            $this->dispatch('update-table');
            $this->dispatch('payment-saved');
        } catch (\Throwable $th) {
            $this->notification()->error('Error', $th->getMessage());
        }
    }
}

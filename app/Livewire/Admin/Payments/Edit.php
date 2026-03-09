<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payments;
use App\Models\PaymentMethodType;
use App\Models\Ventas;
use App\Models\Recibos;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class Edit extends Component
{
    use WireUiActions;

    public $modalEdit = false;
    public Payments $payment;
    public $numero;
    public $numero_operacion;
    public $fecha;
    public $nota;
    public $documento;
    public $divisa;
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
        return view('livewire.admin.payments.edit', compact('paymentMethods'));
    }

    public function updatedTipoPago($tipo_pago)
    {
        $this->reset('paymentable_id', 'divisaDoc', 'monto');

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

                // Calcular pagos previos (excluyendo el pago actual en edición)
                $this->pagosPrevios = Payments::where('paymentable_type', 'App\\Models\\Ventas')
                    ->where('paymentable_id', $paymentable_id)
                    ->where('id', '!=', $this->payment->id)
                    ->sum('monto');

                $this->saldoPendiente = $this->totalDocumento - $this->pagosPrevios;
                $this->monto = min($this->monto, $this->saldoPendiente);

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

                // Calcular pagos previos (excluyendo el pago actual en edición)
                $this->pagosPrevios = Payments::where('paymentable_type', 'App\\Models\\Recibos')
                    ->where('paymentable_id', $paymentable_id)
                    ->where('id', '!=', $this->payment->id)
                    ->sum('monto');

                $this->saldoPendiente = $this->totalDocumento - $this->pagosPrevios;
                $this->monto = min($this->monto, $this->saldoPendiente);

                // Auto-marcar si el saldo se completa
                $this->marcar_como_pagado = false;
            }
        }
    }

    public function loadFacturas($currentId = null)
    {
        $data = [];

        // Cargar facturas UNPAID
        $facturas = Ventas::where('pago_estado', 'UNPAID')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($facturas as $invoice) {
            $data[] = [
                'id' => (string) $invoice->id,
                'text' => $invoice->serie_correlativo,
                'fecha_emision' => $invoice->fecha_emision->format('d-m-Y'),
                'monto' => $invoice->total,
                'divisa' => $invoice->divisa,
            ];
        }

        // Si hay un documento actual y no está en la lista, agregarlo
        if ($currentId && !collect($data)->pluck('id')->contains((string) $currentId)) {
            $documentoActual = Ventas::find($currentId);
            if ($documentoActual) {
                array_unshift($data, [
                    'id' => (string) $documentoActual->id,
                    'text' => $documentoActual->serie_correlativo . ' (Actual)',
                    'fecha_emision' => $documentoActual->fecha_emision->format('d-m-Y'),
                    'monto' => $documentoActual->total,
                    'divisa' => $documentoActual->divisa,
                ]);
            }
        }

        return $data;
    }

    public function loadRecibos($currentId = null)
    {
        $data = [];

        // Cargar recibos UNPAID
        $recibos = Recibos::unpaid()
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($recibos as $recibo) {
            $data[] = [
                'id' => (string) $recibo->id,
                'text' => $recibo->serie_numero,
                'fecha_emision' => $recibo->created_at->format('d-m-Y'),
                'monto' => $recibo->total,
                'divisa' => $recibo->divisa,
            ];
        }

        // Si hay un documento actual y no está en la lista, agregarlo
        if ($currentId && !collect($data)->pluck('id')->contains((string) $currentId)) {
            $documentoActual = Recibos::find($currentId);
            if ($documentoActual) {
                array_unshift($data, [
                    'id' => (string) $documentoActual->id,
                    'text' => $documentoActual->serie_numero . ' (Actual)',
                    'fecha_emision' => $documentoActual->created_at->format('d-m-Y'),
                    'monto' => $documentoActual->total,
                    'divisa' => $documentoActual->divisa,
                ]);
            }
        }

        return $data;
    }

    #[On('open-modal-edit')]
    public function openModal($id)
    {
        $payment = Payments::find($id);

        if (!$payment) {
            $this->notification()->error('Error', 'Pago no encontrado');
            return;
        }

        $this->modalEdit = true;
        $this->payment = $payment;
        $this->numero = $payment->numero;
        $this->numero_operacion = $payment->numero_operacion;
        $this->fecha = $payment->fecha?->format('Y-m-d');
        $this->nota = $payment->nota;
        $this->documento = $payment->documento;
        $this->divisa = $payment->divisa;
        $this->monto = $payment->monto;
        $this->payment_method_id = $payment->payment_method_id;
        $this->cobros_id = $payment->cobros_id;
        $this->paymentable_type = $payment->paymentable_type;

        // Cargar documentos según el tipo (ANTES de asignar paymentable_id)
        if ($payment->paymentable_type == 'App\\Models\\Ventas') {
            $this->tipo_pago = 'FACTURA';
            $this->titulo_documento = 'Numero Factura o Boleta';
            $this->documentos = $this->loadFacturas($payment->paymentable_id);

            // Calcular saldo pendiente
            if ($payment->paymentable_id) {
                $documento = Ventas::find($payment->paymentable_id);
                if ($documento) {
                    $this->totalDocumento = $documento->total;
                    $this->pagosPrevios = Payments::where('paymentable_type', 'App\\Models\\Ventas')
                        ->where('paymentable_id', $payment->paymentable_id)
                        ->where('id', '!=', $payment->id)
                        ->sum('monto');
                    $this->saldoPendiente = $this->totalDocumento - $this->pagosPrevios;
                    $this->divisaDoc = $documento->divisa;
                }
            }
        } elseif ($payment->paymentable_type == 'App\\Models\\Recibos') {
            $this->tipo_pago = 'RECIBO';
            $this->titulo_documento = 'Numero Recibo';
            $this->documentos = $this->loadRecibos($payment->paymentable_id);

            // Calcular saldo pendiente
            if ($payment->paymentable_id) {
                $documento = Recibos::find($payment->paymentable_id);
                if ($documento) {
                    $this->totalDocumento = $documento->total;
                    $this->pagosPrevios = Payments::where('paymentable_type', 'App\\Models\\Recibos')
                        ->where('paymentable_id', $payment->paymentable_id)
                        ->where('id', '!=', $payment->id)
                        ->sum('monto');
                    $this->saldoPendiente = $this->totalDocumento - $this->pagosPrevios;
                    $this->divisaDoc = $documento->divisa;
                }
            }
        } else {
            $this->tipo_pago = 'FACTURA';
            $this->documentos = $this->loadFacturas();
        }

        // Asignar paymentable_id DESPUÉS de cargar los documentos (string para que coincida con los valores del select)
        $this->paymentable_id = (string) $payment->paymentable_id;
    }

    public function closeModal()
    {
        $this->modalEdit = false;
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

    public function update()
    {
        $this->validate([
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'payment_method_id' => 'required|exists:payment_method_types,id',
            'numero_operacion' => 'nullable|string|max:191',
            'documento' => 'nullable|string|max:191',
            'nota' => 'nullable|string|max:500',
            'divisa' => 'required|in:PEN,USD',
        ], [
            'fecha.required' => 'La fecha es obligatoria',
            'monto.required' => 'El monto es obligatorio',
            'monto.numeric' => 'El monto debe ser un valor numérico',
            'payment_method_id.required' => 'Debe seleccionar un método de pago',
        ]);

        try {
            $this->payment->update([
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
            $this->notification()->success('Pago actualizado', 'El pago fue actualizado correctamente');
            $this->dispatch('update-table');
            $this->dispatch('payment-updated');
        } catch (\Throwable $th) {
            $this->notification()->error('Error', $th->getMessage());
        }
    }
}

<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payments;
use App\Models\PaymentMethodType;
use App\Models\BankAccount;
use App\Models\Ventas;
use App\Models\Recibos;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use WireUi\Traits\WireUiActions;
use App\Http\Controllers\Admin\PaymentsController;
use App\Helpers\PaymentDestinationHelper;

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
    public $bank_account_id;
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
    public $showBankAccountSelector = false;
    public $bankAccounts = [];
    public $payment_destination_id; // Destino: formato "tipo|id"
    public $showDestinationSelector = true; // Siempre mostrar selector de destino

    #[Computed]
    public function paymentDestinations()
    {
        return PaymentDestinationHelper::getPaymentDestinations();
    }

    public function render()
    {
        $paymentMethods = PaymentMethodType::whereActive(true)->get();
        return view('livewire.admin.payments.save', compact('paymentMethods'));
    }

    public function updatedPaymentMethodId($payment_method_id)
    {
        if (!$payment_method_id) {
            return;
        }

        $paymentMethod = PaymentMethodType::find($payment_method_id);

        // Si es efectivo (is_cash = 1), auto-seleccionar caja si solo hay una
        if ($paymentMethod && $paymentMethod->is_cash == 1) {
            $destinations = $this->paymentDestinations();
            $cashes = $destinations->where('type', 'cash');

            if ($cashes->count() === 1) {
                $this->payment_destination_id = $cashes->first()['id'];
            }
        }
        // Si es bancario, el usuario debe seleccionar la cuenta manualmente
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

                // Verificar si tiene saldo pendiente
                if ($this->saldoPendiente <= 0) {
                    $this->notification()->error(
                        'Documento Pagado',
                        'Esta factura ya está completamente pagada. No se pueden registrar más pagos.'
                    );
                    $this->reset('paymentable_id', 'divisaDoc', 'monto', 'totalDocumento', 'pagosPrevios', 'saldoPendiente');
                    return;
                }

                $this->monto = $this->saldoPendiente;
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

                // Verificar si tiene saldo pendiente
                if ($this->saldoPendiente <= 0) {
                    $this->notification()->error(
                        'Documento Pagado',
                        'Este recibo ya está completamente pagado. No se pueden registrar más pagos.'
                    );
                    $this->reset('paymentable_id', 'divisaDoc', 'monto', 'totalDocumento', 'pagosPrevios', 'saldoPendiente');
                    return;
                }

                $this->monto = $this->saldoPendiente;
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
            // Calcular saldo pendiente para cada factura
            $pagosPrevios = Payments::where('paymentable_type', 'App\\Models\\Ventas')
                ->where('paymentable_id', $invoice->id)
                ->sum('monto');

            $saldoPendiente = $invoice->total - $pagosPrevios;

            // Solo agregar si tiene saldo pendiente
            if ($saldoPendiente > 0) {
                $data[] = [
                    'id' => $invoice->id,
                    'text' => $invoice->serie_correlativo . ' - Saldo: ' . number_format($saldoPendiente, 2),
                    'fecha_emision' => $invoice->fecha_emision->format('d-m-Y'),
                    'monto' => $invoice->total,
                    'divisa' => $invoice->divisa,
                ];
            }
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
            // Calcular saldo pendiente para cada recibo
            $pagosPrevios = Payments::where('paymentable_type', 'App\\Models\\Recibos')
                ->where('paymentable_id', $recibo->id)
                ->sum('monto');

            $saldoPendiente = $recibo->total - $pagosPrevios;

            // Solo agregar si tiene saldo pendiente
            if ($saldoPendiente > 0) {
                $data[] = [
                    'id' => $recibo->id,
                    'text' => $recibo->serie_numero . ' - Saldo: ' . number_format($saldoPendiente, 2),
                    'fecha_emision' => $recibo->created_at->format('d-m-Y'),
                    'monto' => $recibo->total,
                    'divisa' => $recibo->divisa,
                ];
            }
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

        // Verificar si hay destinos disponibles
        $this->checkAvailableDestinations();

        // Auto-seleccionar caja si solo hay una
        $destinations = $this->paymentDestinations();
        if ($destinations->count() == 1) {
            $this->payment_destination_id = $destinations->first()['id'];
        }
    }

    /**
     * Verificar si hay cajas abiertas o cuentas bancarias activas
     */
    protected function checkAvailableDestinations()
    {
        $hasCash = \App\Models\Cash::where('estado', true)->exists();
        $hasBankAccount = \App\Models\BankAccount::where('status', true)->exists();

        if (!$hasCash && !$hasBankAccount) {
            $this->notification()->warning(
                '⚠️ Sin Destinos Disponibles',
                'No hay cajas abiertas ni cuentas bancarias activas. El pago se registrará pero deberá asignar un destino después.'
            );
        } elseif (!$hasCash) {
            $this->notification()->info(
                '💼 Sin Caja Abierta',
                'No hay cajas abiertas. Para pagos en efectivo, el movimiento quedará sin destino hasta que abra una caja.'
            );
        }
    }

    public function closeModal()
    {
        $this->modalSave = false;
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
            'bank_account_id',
            'cobros_id',
            'tipo_pago',
            'documentos',
            'paymentable_type',
            'paymentable_id',
            'divisaDoc',
            'totalDocumento',
            'pagosPrevios',
            'saldoPendiente',
            'showBankAccountSelector',
            'bankAccounts',
            'payment_destination_id'
        ]);
        $this->resetValidation();
    }

    public function save()
    {
        $rules = [
            'numero' => 'required|string|max:191',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0.01',
            'payment_method_id' => 'required|exists:payment_method_types,id',
            'payment_destination_id' => 'required', // ✅ Obligatorio: 'cash' o ID de cuenta
            'numero_operacion' => 'nullable|string|max:191',
            'documento' => 'nullable|string|max:191',
            'nota' => 'nullable|string|max:500',
            'divisa' => 'required|in:PEN,USD',
        ];

        $messages = [
            'numero.required' => 'El número es obligatorio',
            'fecha.required' => 'La fecha es obligatoria',
            'monto.required' => 'El monto es obligatorio',
            'monto.numeric' => 'El monto debe ser un valor numérico',
            'monto.min' => 'El monto debe ser mayor a 0',
            'payment_method_id.required' => 'Debe seleccionar un método de pago',
            'payment_destination_id.required' => 'Debe seleccionar un destino (caja o cuenta bancaria)',
        ];

        $this->validate($rules, $messages);

        // Validar que si hay documento seleccionado, haya saldo pendiente
        if ($this->paymentable_id && $this->saldoPendiente <= 0) {
            $this->notification()->error('Error', 'Este documento ya está completamente pagado');
            return;
        }

        // Validar que el monto no exceda el saldo pendiente
        if ($this->paymentable_id && $this->monto > $this->saldoPendiente) {
            $this->notification()->error(
                'Error',
                'El monto no puede ser mayor al saldo pendiente de ' .
                    number_format($this->saldoPendiente, 2) . ' ' . $this->divisaDoc
            );
            return;
        }

        try {
            // Parsear destination_type y destination_id desde formato "tipo|id"
            $destinationRecord = PaymentDestinationHelper::parseDestination($this->payment_destination_id);

            if (!$destinationRecord['destination_id']) {
                $this->notification()->error(
                    'Error',
                    'No hay destino válido seleccionado. Verifique que exista una caja abierta o cuenta bancaria activa.'
                );
                return;
            }

            // Crear pago con destination_type y destination_id directos
            $payment = Payments::create([
                'numero' => $this->numero,
                'numero_operacion' => $this->numero_operacion,
                'fecha' => $this->fecha,
                'nota' => $this->nota,
                'documento' => $this->documento,
                'divisa' => $this->divisa,
                'monto' => $this->monto,
                'payment_method_id' => $this->payment_method_id,
                'destination_type' => $destinationRecord['destination_type'],
                'destination_id' => $destinationRecord['destination_id'],
                'bank_account_id' => $this->bank_account_id,
                'cobros_id' => $this->cobros_id,
                'paymentable_type' => $this->paymentable_type,
                'paymentable_id' => $this->paymentable_id,
            ]);

            // Verificar automáticamente si el documento está completamente pagado
            if ($this->paymentable_id) {
                if ($this->paymentable_type == 'App\\Models\\Ventas') {
                    $documento = Ventas::find($this->paymentable_id);
                    if ($documento) {
                        // Calcular el total de pagos realizados (incluyendo el nuevo)
                        $totalPagos = Payments::where('paymentable_type', 'App\\Models\\Ventas')
                            ->where('paymentable_id', $this->paymentable_id)
                            ->sum('monto');

                        // Si los pagos cubren el total, marcar como pagado
                        if ($totalPagos >= $documento->total) {
                            $documento->update([
                                'pago_estado' => 'PAID',
                                'estado' => 'COMPLETADO'
                            ]);
                        }
                    }
                } elseif ($this->paymentable_type == 'App\\Models\\Recibos') {
                    $documento = Recibos::find($this->paymentable_id);
                    if ($documento) {
                        // Calcular el total de pagos realizados (incluyendo el nuevo)
                        $totalPagos = Payments::where('paymentable_type', 'App\\Models\\Recibos')
                            ->where('paymentable_id', $this->paymentable_id)
                            ->sum('monto');

                        // Si los pagos cubren el total, marcar como pagado
                        if ($totalPagos >= $documento->total) {
                            $documento->update([
                                'pago_estado' => 'PAID',
                                'estado' => 'COMPLETADO'
                            ]);
                        }
                    }
                }
            }

            // Primero notificar el éxito
            $this->notification()->success('Pago guardado', 'El pago fue registrado correctamente');

            $this->closeModal();

            // Actualizar tabla después de cerrar
            $this->dispatch('update-table');
        } catch (\Throwable $th) {
            $this->notification()->error('Error', $th->getMessage());
        }
    }
}

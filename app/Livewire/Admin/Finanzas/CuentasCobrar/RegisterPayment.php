<?php

namespace App\Livewire\Admin\Finanzas\CuentasCobrar;

use Carbon\Carbon;
use App\Models\Ventas;
use App\Models\Recibos;
use Livewire\Component;
use App\Models\Payments;
use App\Models\BankAccount;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use WireUi\Traits\WireUiActions;
use App\Models\PaymentMethodType;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PaymentDestinationHelper;
use App\Http\Requests\PaymentsRequest;
use App\Http\Controllers\Admin\PaymentsController;

/**
 * Componente para registrar pagos de facturas/recibos a CRÉDITO
 * Similar al modal de payments.vue de FactuPRO
 */
class RegisterPayment extends Component
{
    use WireUiActions;

    public $modalPayment = false;
    public $showNewPaymentRow = false;

    // Documento que se está pagando
    public $paymentable_type; // 'App\Models\Ventas' o 'App\Models\Recibos'
    public $paymentable_id;
    public $document; // Instancia del documento

    // Pagos existentes del documento
    public $existing_payments = [];
    public $total_pendiente = 0;

    // Formulario de nuevo pago
    public $fecha;
    public $payment_method_id = 1;
    public $payment_destination_id; // 'cash' o ID de cuenta bancaria
    public $monto;
    public $numero_operacion;
    public $nota;

    // Catálogos
    public $paymentsMethods = [];

    public function mount()
    {
        $this->paymentsMethods = PaymentMethodType::whereActive(true)->orderByDescription()->get();
        $this->fecha = now()->format('Y-m-d');
    }

    /**
     * Obtener destinos de pago disponibles (Cajas y Cuentas Bancarias)
     * Similar a Emitir.php
     */
    #[Computed]
    public function paymentDestinations()
    {
        return PaymentDestinationHelper::getPaymentDestinations();
    }

    public function render()
    {
        return view('livewire.admin.finanzas.cuentas-cobrar.register-payment');
    }

    #[On('open-modal-register-payment')]
    public function openModal($paymentable_type, $paymentable_id)
    {
        $this->reset(['monto', 'numero_operacion', 'nota', 'payment_destination_id']);
        $this->showNewPaymentRow = false;

        // Convertir tipo simple a namespace completo
        $this->paymentable_type = $paymentable_type === 'ventas'
            ? 'App\\Models\\Ventas'
            : 'App\\Models\\Recibos';
        $this->paymentable_id = $paymentable_id;

        // Cargar documento
        $this->loadDocument();

        // Cargar pagos existentes
        $this->loadExistingPayments();

        // Calcular monto pendiente
        $this->calculatePending();

        // Auto-llenar con el monto pendiente
        $this->monto = $this->total_pendiente;

        $this->modalPayment = true;
    }

    protected function loadDocument()
    {
        if ($this->paymentable_type === 'App\\Models\\Ventas') {
            $this->document = Ventas::with('cliente')->findOrFail($this->paymentable_id);
        } else {
            $this->document = Recibos::with('cliente')->findOrFail($this->paymentable_id);
        }
    }

    protected function loadExistingPayments()
    {
        $this->existing_payments = Payments::where('paymentable_type', $this->paymentable_type)
            ->where('paymentable_id', $this->paymentable_id)
            ->with(['paymentMethod', 'destination'])
            ->orderBy('fecha', 'desc')
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'fecha' => $payment->fecha->format('d/m/Y'),
                    'metodo' => $payment->paymentMethod->description ?? '-',
                    'destino' => $payment->destination_description,
                    'monto' => $payment->divisa . ' ' . number_format($payment->monto, 2),
                    'numero_operacion' => $payment->numero_operacion,
                    'usuario' => $payment->user->name ?? '-',
                ];
            })
            ->toArray();
    }

    protected function calculatePending()
    {
        $total_documento = (float) $this->document->total;

        $total_pagado = Payments::where('paymentable_type', $this->paymentable_type)
            ->where('paymentable_id', $this->paymentable_id)
            ->sum('monto');

        $this->total_pendiente = max(0, $total_documento - $total_pagado);
    }

    public function closeModal()
    {
        $this->modalPayment = false;
    }

    public function save()
    {

        // Validar que no exceda el pendiente
        if ($this->monto > $this->total_pendiente) {
            $this->notification()->error(
                'Error',
                'El monto ingresado supera el monto pendiente de pago'
            );
            return;
        }

        // Validar destino
        if (empty($this->payment_destination_id)) {
            $this->notification()->error(
                'Error',
                'Debe seleccionar un destino (caja o cuenta bancaria)'
            );
            return;
        }

        // Validar monto
        $request = new PaymentsRequest();
        $this->validate([
            'monto' => $request->rules()['monto'],
            'fecha' => 'required|date',
            'payment_method_id' => 'required|exists:payment_method_types,id',
        ], $request->messages());

        try {
            // Validar destino usando helper
            $destinationRecord = PaymentDestinationHelper::getDestinationRecord($this->payment_destination_id);

            if (!$destinationRecord['destination_id']) {
                $this->notification()->error(
                    'Error',
                    'No hay destino válido. Por favor seleccione una caja o cuenta bancaria.'
                );
                return;
            }

            // Crear pago
            $paymentController = new PaymentsController();
            $numero = $paymentController->setNextSequenceNumber();

            // ✅ IMPORTANTE: Solo enviar payment_destination_id original ('cash' o ID de banco)
            // El Observer lo resolverá automáticamente a payment_destination_type y payment_destination_id
            $payment = Payments::create([
                'numero' => $numero,
                'fecha' => $this->fecha,
                'payment_method_id' => $this->payment_method_id,
                'monto' => $this->monto,
                'divisa' => $this->document->divisa,
                'numero_operacion' => $this->numero_operacion,
                'nota' => $this->nota,
                'paymentable_type' => $this->paymentable_type,
                'paymentable_id' => $this->paymentable_id,
                'payment_destination_id' => $this->payment_destination_id, // 'cash' o ID banco SIN resolver
                'type_movement' => 'INGRESO',
                'user_id' => Auth::user()->id,
            ]);

            // Actualizar estado del documento si está totalmente pagado
            $this->updateDocumentStatus();

            $this->notification()->success(
                'Éxito',
                'Pago registrado correctamente.'
            );

            // Recargar datos
            $this->loadExistingPayments();
            $this->calculatePending();
            $this->showNewPaymentRow = false;
            $this->reset(['monto', 'numero_operacion', 'nota', 'payment_destination_id']);
            $this->fecha = now()->format('Y-m-d');
            $this->payment_method_id = 1;

            $this->dispatch('update-cuentas-cobrar');
        } catch (\Exception $e) {

            $this->notification()->error(
                'Error',
                'Error al registrar el pago: ' . $e->getMessage()
            );
        }
    }

    protected function updateDocumentStatus()
    {
        $total_pagado = Payments::where('paymentable_type', $this->paymentable_type)
            ->where('paymentable_id', $this->paymentable_id)
            ->sum('monto');

        $total_documento = (float) $this->document->total;

        if ($total_pagado >= $total_documento) {
            $this->document->update(['pago_estado' => 'PAID']);

            // Actualizar AccountReceivable si existe
            if ($this->document->accountReceivable) {
                $this->document->accountReceivable->update([
                    'monto_pagado' => $total_pagado,
                    'saldo_pendiente' => 0,
                    'estado' => 'PAGADO',
                ]);
            }
        }
    }

    public function showNewPayment()
    {
        $this->showNewPaymentRow = true;
        $this->monto = $this->total_pendiente;
    }

    public function cancelNewPayment()
    {
        $this->showNewPaymentRow = false;
        $this->reset(['monto', 'numero_operacion', 'nota', 'payment_destination_id']);
        $this->fecha = now()->format('Y-m-d');
        $this->payment_method_id = 1;
    }

    public function deletePayment($paymentId)
    {
        try {
            $payment = Payments::findOrFail($paymentId);

            // Validar que no esté asociado a un cobro
            if ($payment->cobros_id) {
                $this->notification()->error(
                    'Error',
                    'No se puede eliminar este pago porque está asociado a un cobro. Primero desasócielo desde el módulo de cobros.'
                );
                return;
            }

            $payment->delete();

            $this->notification()->success(
                'Éxito',
                'Pago eliminado correctamente'
            );

            // Recargar datos
            $this->loadExistingPayments();
            $this->calculatePending();
            $this->dispatch('update-cuentas-cobrar');
        } catch (\Exception $e) {
            $this->notification()->error(
                'Error',
                'Error al eliminar el pago: ' . $e->getMessage()
            );
        }
    }
}

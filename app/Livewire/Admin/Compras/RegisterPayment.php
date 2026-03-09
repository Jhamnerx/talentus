<?php

namespace App\Livewire\Admin\Compras;

use Carbon\Carbon;
use App\Models\Compras;
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
 * Componente para registrar pagos de compras a CRÉDITO
 * Es EGRESO: sale dinero desde caja/banco hacia el proveedor
 */
class RegisterPayment extends Component
{
    use WireUiActions;

    public $modalPayment = false;
    public $showNewPaymentRow = false;

    // Documento que se está pagando
    public $compra_id;
    public $compra; // Instancia de la compra

    // Pagos existentes del documento
    public $existing_payments = [];
    public $total_pendiente = 0;

    // Formulario de nuevo pago
    public $fecha;
    public $payment_method_id = 1;
    public $payment_destination_id; // Caja o ID de cuenta bancaria DESDE donde sale el dinero
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
     * En este caso son ORÍGENES (de donde sale el dinero)
     */
    #[Computed]
    public function paymentDestinations()
    {
        return PaymentDestinationHelper::getPaymentDestinations();
    }

    public function render()
    {
        return view('livewire.admin.compras.register-payment');
    }

    #[On('open-modal-payments')]
    #[On('open-modal-register-payment-compras')]
    public function openModal($compraId = null, $paymentable_id = null)
    {
        // Soporte para ambos eventos (compras e cuentas por pagar)
        $this->compra_id = $compraId ?? $paymentable_id;

        $this->reset(['monto', 'numero_operacion', 'nota', 'payment_destination_id']);
        $this->showNewPaymentRow = false;

        // Cargar compra
        $this->loadCompra();

        // Cargar pagos existentes
        $this->loadExistingPayments();

        // Calcular monto pendiente
        $this->calculatePending();

        // Auto-llenar con el monto pendiente
        $this->monto = $this->total_pendiente;

        $this->modalPayment = true;
    }

    protected function loadCompra()
    {
        $this->compra = Compras::with('proveedor')->findOrFail($this->compra_id);
    }

    protected function loadExistingPayments()
    {
        $this->existing_payments = Payments::where('paymentable_type', Compras::class)
            ->where('paymentable_id', $this->compra_id)
            ->with(['paymentMethod', 'destination'])
            ->orderBy('fecha', 'desc')
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'fecha' => $payment->fecha->format('d/m/Y'),
                    'metodo' => $payment->paymentMethod->description ?? '-',
                    'origen' => $payment->destination_description,
                    'monto' => $payment->divisa . ' ' . number_format($payment->monto, 2),
                    'numero_operacion' => $payment->numero_operacion,
                    'usuario' => $payment->user->name ?? '-',
                ];
            })
            ->toArray();
    }

    protected function calculatePending()
    {
        $total_documento = (float) $this->compra->total;

        $total_pagado = Payments::where('paymentable_type', Compras::class)
            ->where('paymentable_id', $this->compra_id)
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

        // Validar origen (de donde sale el dinero)
        if (empty($this->payment_destination_id)) {
            $this->notification()->error(
                'Error',
                'Debe seleccionar desde dónde sale el dinero (caja o cuenta bancaria)'
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
            // Parsear destination_type y destination_id desde formato "tipo|id"
            $destinationRecord = PaymentDestinationHelper::parseDestination($this->payment_destination_id);

            if (!$destinationRecord['destination_id']) {
                $this->notification()->error(
                    'Error',
                    'No hay origen válido. Por favor seleccione una caja o cuenta bancaria.'
                );
                return;
            }

            // Crear pago con destination_type y destination_id directos
            // El Observer detectará que es Compras y asignará type_movement = 'EGRESO'
            $paymentController = new PaymentsController();
            $numero = $paymentController->setNextSequenceNumber();

            $payment = Payments::create([
                'numero' => $numero,
                'fecha' => $this->fecha,
                'payment_method_id' => $this->payment_method_id,
                'monto' => $this->monto,
                'divisa' => $this->compra->divisa,
                'tipo_cambio' => $this->compra->tipo_cambio ?? 1,
                'numero_operacion' => $this->numero_operacion,
                'nota' => $this->nota,
                'paymentable_type' => Compras::class,
                'paymentable_id' => $this->compra_id,
                'destination_type' => $destinationRecord['destination_type'],
                'destination_id' => $destinationRecord['destination_id'],
                // type_movement, user_id, empresa_id se asignan en PaymentsObserver
            ]);

            // Actualizar estado del documento si está totalmente pagado
            $this->updateCompraStatus();

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

            $this->dispatch('update-table');
        } catch (\Exception $e) {
            $this->notification()->error(
                'Error',
                'Error al registrar el pago: ' . $e->getMessage()
            );
        }
    }

    protected function updateCompraStatus()
    {
        $total_pagado = Payments::where('paymentable_type', Compras::class)
            ->where('paymentable_id', $this->compra_id)
            ->sum('monto');

        $total_documento = (float) $this->compra->total;

        if ($total_pagado >= $total_documento) {
            $this->compra->update(['pago_estado' => 'PAID']);
        } elseif ($total_pagado > 0) {
            $this->compra->update(['pago_estado' => 'PARCIAL']);
        } else {
            $this->compra->update(['pago_estado' => 'PENDIENTE']);
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

            $payment->delete();

            $this->notification()->success(
                'Éxito',
                'Pago eliminado correctamente'
            );

            // Recargar datos
            $this->loadExistingPayments();
            $this->calculatePending();
            $this->updateCompraStatus();
            $this->dispatch('update-table');
        } catch (\Exception $e) {
            $this->notification()->error(
                'Error',
                'Error al eliminar el pago: ' . $e->getMessage()
            );
        }
    }
}

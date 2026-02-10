<?php

namespace App\Livewire\Admin\Cobros;

use Carbon\Carbon;
use App\Models\Cobros;
use App\Models\Ventas;
use App\Models\Recibos;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Payments;
use App\Models\BankAccount;
use Livewire\Attributes\On;
use App\Models\DetalleCobros;
use App\Models\PaymentMethodType;
use App\Http\Requests\PaymentsRequest;
use App\Http\Controllers\Admin\PaymentsController;


class Payment extends Component
{
    public $modalPayment = false;

    public $tipo_pago = "FACTURA";
    public $documentos = [];
    public $titulo_documento = "Numero";

    public $paymentsMethods = [];

    public DetalleCobros $detalle;
    public Cobros $cobro;

    public $numero, $payment_method_id = 1, $bank_account_id, $nota, $monto, $paymentable_type, $paymentable_id, $numero_operacion, $divisaDoc, $divisa;
    public $payment_destination_id; // Destino: 'cash' o ID de cuenta bancaria
    public $availableCashes = [];
    public $showBankAccountSelector = false;
    public $bankAccounts = [];

    // Modo: crear nuevo o asociar existente
    public $paymentMode = 'create'; // 'create' o 'associate'
    public $existing_payment_id = null;
    public $existingPayments = [];

    public function mount()
    {
        $this->paymentsMethods = PaymentMethodType::whereActive(true)->get();

        // Cargar destinos disponibles
        $this->availableCashes = \App\Models\Cash::where('estado', true)->get();
        $this->bankAccounts = \App\Models\BankAccount::where('status', true)->get();
    }

    public function render()
    {
        return view('livewire.admin.cobros.payment');
    }

    public function updatedPaymentMethodId($payment_method_id)
    {
        if (!$payment_method_id) {
            $this->showBankAccountSelector = false;
            $this->bank_account_id = null;
            return;
        }

        $paymentMethod = PaymentMethodType::find($payment_method_id);

        // Mostrar selector si es depósito bancario (is_credit = 1)
        if ($paymentMethod && $paymentMethod->is_credit == 1) {
            $this->showBankAccountSelector = true;
            $this->bankAccounts = BankAccount::active()->get();
        } else {
            $this->showBankAccountSelector = false;
            $this->bank_account_id = null;
        }
    }

    #[On('open-modal-payment')]
    public function openModal(DetalleCobros $detalle)
    {
        $paymentController = new PaymentsController();
        $this->numero = $paymentController->setNextSequenceNumber();

        $this->detalle = $detalle;
        $this->cobro = $detalle->cobro;
        $this->divisa = $detalle->cobro->divisa;
        $this->monto = $detalle->plan;

        $cliente = Clientes::where('id', $detalle->cobro->clientes_id)->first();

        if ($this->cobro->tipo_pago == "FACTURA") {

            $this->titulo_documento = "Numero Factura o Boleta";
            $this->tipo_pago = "FACTURA";
            $this->documentos = $this->loadFacturas($cliente);
            $this->paymentable_type = Ventas::class;
        } else {

            $this->titulo_documento = "Numero Recibo";
            $this->tipo_pago = "RECIBO";
            $this->documentos = $this->loadRecibos($cliente);
            $this->paymentable_type = Recibos::class;
        }

        $this->modalPayment = true;

        // Verificar si hay cajas o cuentas disponibles
        $this->checkAvailableDestinations();

        // Cargar pagos existentes disponibles
        $this->loadExistingPayments($cliente);
    }

    /**
     * Verificar si hay cajas abiertas o cuentas bancarias activas
     */
    protected function checkAvailableDestinations()
    {
        $hasCash = \App\Models\Cash::where('estado', true)->exists();
        $hasBankAccount = BankAccount::where('status', true)->exists();

        if (!$hasCash && !$hasBankAccount) {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: '⚠️ Sin Destinos Disponibles',
                mensaje: 'No hay cajas abiertas ni cuentas bancarias activas. El pago se registrará pero deberá asignar un destino después.',
            );
        } elseif (!$hasCash) {
            $this->dispatch(
                'notify-toast',
                icon: 'info',
                title: '💼 Sin Caja Abierta',
                mensaje: 'No hay cajas abiertas. Para pagos en efectivo, el movimiento quedará sin destino hasta que abra una caja.',
            );
        }
    }

    /**
     * Cargar pagos existentes del cliente que pueden asociarse
     * MODIFICADO: Ahora acepta pagos de CONTADO y CRÉDITO
     */
    protected function loadExistingPayments($cliente)
    {
        if (!$cliente) return;

        // Obtener TODOS los pagos del cliente que:
        // - Estén asociados a Ventas/Recibos (sin importar forma_pago)
        // - No tengan cobros_id asignado aún
        $this->existingPayments = Payments::query()
            ->where(function ($query) use ($cliente) {
                // Ventas/Facturas del cliente (CONTADO o CRÉDITO)
                $query->where('paymentable_type', 'App\\Models\\Ventas')
                    ->whereIn('paymentable_id', \App\Models\Ventas::where('cliente_id', $cliente->id)->pluck('id'));
            })
            ->orWhere(function ($query) use ($cliente) {
                // Recibos del cliente (CONTADO o CRÉDITO)
                $query->where('paymentable_type', 'App\\Models\\Recibos')
                    ->whereIn('paymentable_id', \App\Models\Recibos::where('clientes_id', $cliente->id)->pluck('id'));
            })
            ->whereNull('cobros_id') // Sin cobro asociado
            ->with('paymentable')
            ->latest()
            ->get()
            ->map(function ($payment) {
                $docInfo = '';
                if ($payment->paymentable_type === 'App\\Models\\Ventas') {
                    $docInfo = $payment->paymentable->serie_correlativo ?? 'FAC';
                } elseif ($payment->paymentable_type === 'App\\Models\\Recibos') {
                    $docInfo = $payment->paymentable->serie_numero ?? 'REC';
                }

                return [
                    'id' => $payment->id,
                    'label' => "Pago #{$payment->numero} - {$docInfo} - {$payment->divisa} " . number_format($payment->monto, 2) . " ({$payment->fecha->format('d/m/Y')})",
                    'numero' => $payment->numero,
                    'monto' => $payment->monto,
                    'divisa' => $payment->divisa,
                    'documento' => $docInfo,
                ];
            })
            ->toArray();
    }

    public function updatedPaymentableId($paymentable_id)
    {
        if ($paymentable_id == null) {
            $this->divisaDoc = null;
            return;
        }

        if ($this->paymentable_type == 'App\Models\Ventas') {
            $documento = Ventas::where('id', $paymentable_id)->first();
            $this->divisaDoc = $documento->divisa;

            // Validar que sea a CRÉDITO y esté UNPAID
            if ($documento->forma_pago === 'CONTADO') {
                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'VENTA AL CONTADO',
                    mensaje: 'Esta venta ya tiene pago registrado al contado. No se puede generar otro pago desde Cobros.'
                );
                $this->paymentable_id = null;
                $this->divisaDoc = null;
                return;
            }

            if ($documento->pago_estado === Ventas::PAID) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'warning',
                    title: 'VENTA YA PAGADA',
                    mensaje: 'Esta venta ya fue pagada completamente. No se puede generar otro pago.'
                );
                $this->paymentable_id = null;
                $this->divisaDoc = null;
                return;
            }
        }

        if ($this->paymentable_type == 'App\Models\Recibos') {
            $documento = Recibos::where('id', $paymentable_id)->first();
            $this->divisaDoc = $documento->divisa;

            // Validar que sea a CRÉDITO y esté UNPAID
            if ($documento->tipo_venta === 'CONTADO') {
                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'RECIBO AL CONTADO',
                    mensaje: 'Este recibo ya tiene pago registrado al contado. No se puede generar otro pago desde Cobros.'
                );
                $this->paymentable_id = null;
                $this->divisaDoc = null;
                return;
            }

            if ($documento->pago_estado === Recibos::PAID) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'warning',
                    title: 'RECIBO YA PAGADO',
                    mensaje: 'Este recibo ya fue pagado completamente. No se puede generar otro pago.'
                );
                $this->paymentable_id = null;
                $this->divisaDoc = null;
                return;
            }
        }
    }

    public function closeModal()
    {

        $this->modalPayment = false;
    }

    public function save()
    {
        // Modo ASOCIAR: Solo actualizar cobros_id del pago existente
        if ($this->paymentMode === 'associate') {
            if (empty($this->existing_payment_id)) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'PAGO REQUERIDO',
                    mensaje: 'Debes seleccionar un pago existente para asociar'
                );
                return;
            }

            try {
                $payment = Payments::findOrFail($this->existing_payment_id);
                $payment->update(['cobros_id' => $this->cobro->id]);

                $this->dispatch(
                    'notify-toast',
                    icon: 'success',
                    title: 'PAGO ASOCIADO',
                    mensaje: "Pago #{$payment->numero} asociado al cobro correctamente"
                );

                $this->dispatch('update-cobros');
                $this->closeModal();
                return;
            } catch (\Exception $e) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'ERROR',
                    mensaje: 'Error al asociar el pago: ' . $e->getMessage()
                );
                return;
            }
        }

        // Modo CREAR: Lógica original de creación de pago
        $request = new PaymentsRequest();
        $this->validate($request->rules(), $request->messages());
        $paymentController = new PaymentsController();
        $this->numero = $paymentController->setNextSequenceNumber();

        $payment = Payments::create([
            'numero' => $this->numero,
            'numero_operacion' => $this->numero_operacion,
            'fecha' => Carbon::now()->format('Y-m-d'),
            'nota' => $this->nota,
            'monto' => $this->monto,
            'divisa' => $this->divisaDoc,
            'paymentable_type' => $this->paymentable_type,
            'documento' => $this->paymentable_type == 'App\Models\Facturas' ? 'FACTURA' : 'RECIBO',
            'paymentable_id' => $this->paymentable_id,
            'cobros_id' => $this->cobro->id,
            'payment_method_id' => $this->payment_method_id,
            'payment_destination_id' => $this->payment_destination_id,
            'bank_account_id' => $this->bank_account_id,
        ]);

        // Verificar automáticamente si el documento está completamente pagado
        if ($this->paymentable_id && $payment->paymentable) {
            // Calcular el total de pagos realizados (incluyendo el nuevo)
            $totalPagos = Payments::where('paymentable_type', $this->paymentable_type)
                ->where('paymentable_id', $this->paymentable_id)
                ->sum('monto');

            // Si los pagos cubren el total, marcar como pagado
            if ($totalPagos >= $payment->paymentable->total) {
                $payment->paymentable->pago_estado = 'PAID';
                $payment->paymentable->estado = 'COMPLETADO';
                $payment->paymentable->save();
            }
        }

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'Pago registrado',
            mensaje: 'Se guardo con exito el pago ' . $payment->numero,
        );

        $this->closeModal();
    }

    public function updatedtipoPago($tipo_pago)
    {
        $this->reset('paymentable_type', 'paymentable_id');
        $cliente = Clientes::where('id', $this->cobro->clientes_id)->first();

        if ($tipo_pago == "FACTURA") {

            $this->titulo_documento = "Numero Factura o Boleta";
            $this->documentos = $this->loadFacturas($cliente);
            $this->paymentable_type = Ventas::class;
        } else {

            $this->titulo_documento = "Numero Recibo";
            $this->documentos = $this->loadRecibos($cliente);
            $this->paymentable_type = Recibos::class;
        }
    }

    public function loadFacturas(Clientes $cliente)
    {

        $data = [];

        foreach ($cliente->ventas()->where('pago_estado', 'UNPAID')->get() as $invoice) {

            $data[] = [
                'id' => $invoice->id,
                'text' => $invoice->serie_correlativo,
                'fecha_emision' => $invoice->fecha_emision->format('d-m-Y'),
                'paymentable_type' => Ventas::class,
                'paymentable_id' => $invoice->id,
                'monto' => $invoice->total,
                'divisa' => $invoice->divisa,
            ];
        }

        return $data;
    }

    public function loadRecibos(Clientes $cliente)
    {

        $data = [];
        foreach ($cliente->recibos()->unpaid()->get() as $recibo) {

            $data[] = [
                'id' => $recibo->id,
                'text' => $recibo->serie_numero,
                'fecha_emision' => $recibo->fecha_emision->format('d-m-Y'),
                'paymentable_type' => Recibos::class,
                'paymentable_id' => $recibo->id,
                'monto' => $recibo->total,
                'divisa' => $recibo->divisa,
            ];
        }
        return $data;
    }

    public function updated($attr)
    {
        $request = new PaymentsRequest();
        $this->validateOnly($attr, $request->rules(), $request->messages());
    }
}

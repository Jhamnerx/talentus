<?php

namespace App\Livewire\Admin\Cobros;

use Carbon\Carbon;
use App\Models\Cobros;
use App\Models\Ventas;
use App\Models\Recibos;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Payments;
use Livewire\Attributes\On;
use App\Models\DetalleCobros;
use App\Models\PaymentMethodType;
use App\Http\Requests\PaymentsRequest;
use App\Http\Controllers\Admin\PaymentsController;
use Illuminate\Support\Collection;

class PaymentBulk extends Component
{
    public $modalPayment = false;

    public $tipo_pago = "FACTURA";
    public $documentos = [];
    public $titulo_documento = "Numero";
    public $pay = false;

    public $paymentsMethods = [];

    public Collection $detalles;
    public Cobros $cobro;

    public $numero, $payment_method_id = 1, $nota, $monto = 0, $paymentable_type, $paymentable_id, $numero_operacion, $divisaDoc, $divisa;
    public $auto_renovar = true;

    public function mount()
    {
        $this->paymentsMethods = PaymentMethodType::whereActive(true)->orderByDescription()->get();
        $this->detalles = collect();
    }

    public function render()
    {
        return view('livewire.admin.cobros.payment-bulk');
    }

    #[On('open-modal-payment-bulk')]
    public function openModal(Cobros $cobro, array $detalleIds)
    {
        $paymentController = new PaymentsController();
        $this->numero = $paymentController->setNextSequenceNumber();

        $this->detalles = DetalleCobros::whereIn('id', $detalleIds)->with('vehiculo')->get();
        $this->cobro = $cobro;
        $this->divisa = $cobro->divisa;
        $this->auto_renovar = $cobro->auto_renovar ?? true;

        // Calcular monto total
        $this->monto = $this->detalles->sum('plan');

        $cliente = Clientes::where('id', $cobro->clientes_id)->first();

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
        }

        if ($this->paymentable_type == 'App\Models\Recibos') {
            $documento = Recibos::where('id', $paymentable_id)->first();
            $this->divisaDoc = $documento->divisa;
        }
    }

    public function closeModal()
    {
        $this->modalPayment = false;
        $this->reset(['detalles', 'monto', 'paymentable_id', 'nota', 'numero_operacion']);
    }

    public function save()
    {
        $request = new PaymentsRequest();
        $this->validate($request->rules(), $request->messages());

        $paymentController = new PaymentsController();
        $this->numero = $paymentController->setNextSequenceNumber();

        // Crear el pago
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
            'payment_method_id' => $this->payment_method_id
        ]);

        // Actualizar documento si se marca como pagado
        if ($this->pay == "true" && $payment->paymentable) {
            $payment->paymentable->pago_estado = 'PAID';
            $payment->paymentable->estado = 'COMPLETADO';
            $payment->paymentable->save();
        }

        // Auto-renovar fechas de los detalles si está habilitado
        if ($this->auto_renovar) {
            foreach ($this->detalles as $detalle) {
                $this->renovarFecha($detalle);

                // Registrar facturación
                $detalle->update([
                    'factura_id' => $this->paymentable_id,
                    'fecha_facturado' => Carbon::now()->format('Y-m-d')
                ]);
            }
        }

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'Pago Consolidado Registrado',
            mensaje: 'Se guardó el pago ' . $payment->numero . ' para ' . $this->detalles->count() . ' vehículos',
        );

        $this->dispatch('update-cobros');
        $this->closeModal();
    }

    private function renovarFecha(DetalleCobros $detalle)
    {
        $periodo = $detalle->cobro->periodo;

        $nuevaFecha = match ($periodo) {
            'MENSUAL' => $detalle->fecha->copy()->addMonth(),
            'BIMENSUAL' => $detalle->fecha->copy()->addMonths(2),
            'TRIMESTRAL' => $detalle->fecha->copy()->addMonths(3),
            'SEMESTRAL' => $detalle->fecha->copy()->addMonths(6),
            'ANUAL' => $detalle->fecha->copy()->addYear(),
            default => $detalle->fecha,
        };

        $detalle->update(['fecha' => $nuevaFecha]);
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
                'divisa' => $invoice->divisa,
                'total' => $invoice->total,
                'fecha' => $invoice->fecha_emision->format('d/m/Y'),
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
                'divisa' => $recibo->divisa,
                'total' => $recibo->total,
                'fecha' => $recibo->fecha_emision->format('d/m/Y'),
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

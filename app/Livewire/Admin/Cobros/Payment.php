<?php

namespace App\Livewire\Admin\Cobros;

use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Requests\PaymentsRequest;
use App\Models\Clientes;
use App\Models\Cobros;
use App\Models\DetalleCobros;
use App\Models\PaymentMethods;
use App\Models\Payments;
use App\Models\Recibos;
use App\Models\Ventas;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;


class Payment extends Component
{
    public $modalPayment = false;

    public $tipo_pago = "FACTURA";
    public $documentos = [];
    public $titulo_documento = "Numero";
    public $pay = false;

    public $paymentsMethods = [];

    public DetalleCobros $detalle;
    public Cobros $cobro;

    public $numero, $payment_method_id = 1, $nota, $monto, $paymentable_type, $paymentable_id, $numero_operacion, $divisaDoc, $divisa;


    public function mount()
    {
        $this->paymentsMethods = PaymentMethods::all();
    }

    public function render()
    {
        return view('livewire.admin.cobros.payment');
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
    }

    public function save()
    {

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
            'payment_method_id' => $this->payment_method_id
        ]);

        if ($this->pay == "true") {
            $payment->paymentable->pago_estado = 'PAID';
            $payment->paymentable->estado = 'COMPLETADO';
            $payment->paymentable->save();
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

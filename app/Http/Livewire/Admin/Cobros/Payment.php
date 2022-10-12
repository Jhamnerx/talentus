<?php

namespace App\Http\Livewire\Admin\Cobros;

use App\Http\Controllers\Admin\PaymentsController;
use App\Models\Clientes;
use App\Models\Cobros;
use App\Models\Facturas;
use App\Models\PaymentMethods;
use App\Models\Payments;
use App\Models\Recibos;
use Carbon\Carbon;
use Livewire\Component;


class Payment extends Component
{
    public $modalPayment = false;

    public $tipo_pago = "FACTURA";
    public $documentos = [];
    public $titulo_documento = "Numero";

    public $paymentsMethods = [];

    public $cobro;

    public $numero, $payment_method_id = 1, $nota, $monto, $paymentable_type, $paymentable_id;

    protected $listeners = [
        'openModalPayment' => 'openModal',
    ];

    public function mount(Cobros $cobro)
    {
        $this->cobro = $cobro;
        $this->tipo_pago = $cobro->tipo_pago;
        $this->cobro->reset;
        $this->paymentsMethods = PaymentMethods::all();
        $paymentController = new PaymentsController();
        $this->numero = $paymentController->setNextSequenceNumber();
    }

    public function render()
    {
        return view('livewire.admin.cobros.payment');
    }


    public function save()
    {
        $payment = Payments::create([
            'numero' => $this->numero,
            'fecha' => Carbon::now()->format('Y-m-d'),
            'nota' => $this->nota,
            'monto' => $this->monto,
            'paymentable_type' => $this->paymentable_type,
            'paymentable_id' => $this->paymentable_id,
            'cobros_id' => $this->cobro->id,
            'payment_method_id' => $this->payment_method_id
        ]);

        $payment->paymentable->pago_estado = 'PAID';
        $payment->paymentable->estado = 'COMPLETADO';
        $payment->paymentable->save();

        $this->closeModal();
        //$this->dispatchBrowserEvent('savePayment', ['payment' => $payment]);
        // return redirect()->route('admin.cobros.show', $this->cobro)->with('store', 'Se guardo con exito' . $payment->numero);



        // return redirect()->route('admin.cobros.show', $this->cobro);
        // session()->flash('store', 'Se guardo con exito' . $payment->numero);
        return redirect()->route('admin.cobros.show', $this->cobro)->with('flash.banner', 'Se guardo con exito el pago ' . $payment->numero);
        return redirect()->route('admin.cobros.show', $this->cobro)->with('flash.bannerStyle', 'success');
    }

    public function openModal()
    {

        $this->modalPayment = true;
        $cliente = Clientes::where('id', $this->cobro->clientes_id)->first();

        if ($this->cobro->tipo_pago == "FACTURA") {

            $this->titulo_documento = "Numero Factura";
            $this->documentos = $this->loadFacturas($cliente);
        } else {

            $this->titulo_documento = "Numero Recibo";
            $this->documentos = $this->loadRecibos($cliente);
        }

        $this->dispatchBrowserEvent('dataDocumentos', ['data' => $this->documentos]);
    }

    public function closeModal()
    {

        $this->modalPayment = false;
    }


    public function updatedtipoPago($tipo_pago)
    {
        $this->reset('paymentable_type', 'paymentable_id');
        $cliente = Clientes::where('id', $this->cobro->clientes_id)->first();

        if ($tipo_pago == "FACTURA") {

            $this->titulo_documento = "Numero Factura";
            $this->documentos = $this->loadFacturas($cliente);
        } else {

            $this->titulo_documento = "Numero Recibo";
            $this->documentos = $this->loadRecibos($cliente);
        }

        $this->dispatchBrowserEvent('dataDocumentos', ['data' => $this->documentos]);
    }

    public function loadFacturas(Clientes $cliente)
    {

        $data = [];

        foreach ($cliente->facturas as $factura) {


            if ($factura->is_active) {

                $data[] = [
                    'id' => $factura->id,
                    'text' => $factura->numero,
                    'paymentable_type' => Facturas::class,
                    'paymentable_id' => $factura->id,
                    'monto' => $factura->total,
                ];
            }
        }

        return $data;
    }

    public function loadRecibos(Clientes $cliente)
    {

        $data = [];
        foreach ($cliente->recibos as $recibo) {

            $data[] = [
                'id' => $recibo->id,
                'text' => $recibo->numero,
                'paymentable_type' => Recibos::class,
                'paymentable_id' => $recibo->id,
                'monto' => $recibo->total,
            ];
        }
        return $data;
    }
}

<?php

namespace App\Http\Livewire\Admin\Cobros;

use App\Models\Clientes;
use App\Models\Cobros;
use Livewire\Component;

class Payment extends Component
{
    public $modalPayment = false;

    public $tipo_pago = "FACTURA";
    public $documentos = [];
    public $titulo_documento = "Numero";
    
    public $cobro;

    protected $listeners = [
        'openModalPayment' => 'openModal',
    ];

    public function mount(Cobros $cobro){

        $this->cobro = $cobro;
        $this->tipo_pago = $cobro->tipo_pago;

    }

    public function render()
    {
        return view('livewire.admin.cobros.payment');
    }

    public function openModal(){

        $this->modalPayment = true;
        $cliente = Clientes::where('id',$this->cobro->clientes_id)->first();

        if($this->cobro->tipo_pago == "FACTURA"){

            $this->titulo_documento = "Numero Factura";
            $this->documentos = $this->loadFacturas($cliente);

        }else{

            $this->titulo_documento = "Numero Recibo";
            $this->documentos = $this->loadRecibos($cliente);
        }

        $this->dispatchBrowserEvent('dataDocumentos', ['data' => $this->documentos]);


    }

    public function closeModal(){

        $this->modalPayment = false;

    }


    public function updatedtipoPago($tipo_pago){


        $cliente = Clientes::where('id',$this->cobro->clientes_id)->first();

        if($tipo_pago == "FACTURA"){

            $this->titulo_documento = "Numero Factura";
            $this->documentos = $this->loadFacturas($cliente);

        }else{

            $this->titulo_documento = "Numero Recibo";
            $this->documentos = $this->loadRecibos($cliente);

        }

        $this->dispatchBrowserEvent('dataDocumentos', ['data' => $this->documentos]);
       
        //$this->dataVehiculos = $data;
    }

    public function loadFacturas(Clientes $cliente){

        $data = [];

        foreach($cliente->facturas as $factura){


            if($factura->is_active){

                $data[] = [
                    'id' => $factura->id,
                    'text' => $factura->serie."-".$factura->numero,
                ];
            }

        }

        return $data;
    }

    public function loadRecibos(Clientes $cliente){

        $data = [];
        foreach($cliente->recibos as $recibo){

            $data[] = [
                'id' => $recibo->id,
                'text' => $recibo->serie."-".$recibo->numero,
            ];

        }
        return $data;
    }

}

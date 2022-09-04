<?php

namespace App\Http\Livewire\Admin\Ventas\Facturas;

use App\Http\Controllers\Admin\PDF\FacturaPdfController;
use App\Models\Facturas;
use Exception;
use Livewire\Component;

class Send extends Component
{
    public $modalOpenSend = false;

    public $factura;

    public $from = "talentus@talentustechnology.com", $to, $asunto = "", $body;


    protected $listeners = [
        'modalOpenSend' => 'openModal'
    ];

    public function resetPropiedades(){

        $this->reset('from');
        $this->reset('to');
        $this->reset('asunto');
        $this->reset('body');
        $this->reset('factura');

    }


    public function render()
    {
        return view('livewire.admin.ventas.facturas.send');
    }


    public function openModal(Facturas $factura){
       // dd($factura);
        $this->modalOpenSend = true;
        $this->factura = $factura;
        $this->to = $factura->clientes->email." | ".$factura->clientes->razon_social;
        $this->asunto = "TALENTUS - FACTURA ".$factura->serie."-".$factura->numero;

    }

    public function closeModal()
    {
        $this->modalOpenSend = false;
        $this->resetPropiedades();

    }


    public function sendFactura(){


        $data = array(
            'asunto' => $this->asunto,
            'body' => $this->body,
        );


        try {

            $pdfFactura = new FacturaPdfController();
            $pdfFactura->sendToMail($this->factura, $data);


        } catch (Exception $e) {
            dd($e);
            $e->getMessage();

        }finally{

            $this->modalOpenSend = false;
            $this->dispatchBrowserEvent('factura-send', ['factura' => $this->factura]);
            $this->resetPropiedades();

        }

    }
}

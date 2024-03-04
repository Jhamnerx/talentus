<?php

namespace App\Livewire\Admin\Ventas\Recibos;

use App\Http\Controllers\Admin\PDF\ReciboPdfController;
use App\Models\Recibos;
use Exception;
use Livewire\Component;

class Send extends Component
{

    public $modalOpenSend = false;

    public $recibo;

    public $from = "talentus@talentustechnology.com", $to, $asunto = "", $body;


    protected $listeners = [
        'modalOpenSend' => 'openModal'
    ];

    public function resetPropiedades(){
        $this->reset('from');
        $this->reset('to');
        $this->reset('asunto');
        $this->reset('body');
        $this->reset('recibo');
    }

    public function render()
    {
        return view('livewire.admin.ventas.recibos.send');
    }

    public function openModal(Recibos $recibo){

        $this->modalOpenSend = true;
        $this->recibo = $recibo;
        $this->to = $recibo->clientes->email." | ".$recibo->clientes->razon_social;
        $this->asunto = "TALENTUS RECIBO #".$recibo->serie."-".$recibo->numero;

       // dd($recibo);

    }
    public function closeModal()
    {
        $this->modalOpenSend = false;
        $this->resetPropiedades();

    }


    public function sendRecibo(){


        $data = array(
            'asunto' => $this->asunto,
            'body' => $this->body,
        );

        try {

            $pdfRecibo = new ReciboPdfController();
            $pdfRecibo->sendToMail($this->recibo, $data);


        } catch (Exception $e) {
            dd($e);
            $e->getMessage();

        }finally{

            $this->modalOpenSend = false;
            $this->dispatch('recibo-send', ['recibo' => $this->recibo]);
            
            $this->resetPropiedades();

        }

    }
}

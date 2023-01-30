<?php

namespace App\Http\Livewire\Admin\Gerencia\Recibos;

use Exception;
use Livewire\Component;
use App\Models\RecibosPagosVarios;
use App\Http\Controllers\Admin\PDF\ReciboPagoPdfController;

class Send extends Component
{
    public $modalOpenSend = false;

    public $recibo;

    public $from = "talentus@talentustechnology.com", $to, $asunto = "", $body;


    protected $listeners = [
        'modalOpenSend' => 'openModal'
    ];

    public function resetPropiedades()
    {
        $this->reset('from');
        $this->reset('to');
        $this->reset('asunto');
        $this->reset('body');
        $this->reset('recibo');
    }
    public function render()
    {
        return view('livewire.admin.gerencia.recibos.send');
    }
    public function openModal(RecibosPagosVarios $recibo)
    {

        $this->modalOpenSend = true;
        $this->recibo = $recibo;
        $this->to = $recibo->clientes->email . " | " . $recibo->clientes->razon_social;
        $this->asunto = "TALENTUS RECIBO #" . $recibo->serie . "-" . $recibo->numero;

        // dd($recibo);

    }
    public function closeModal()
    {
        $this->modalOpenSend = false;
        $this->resetPropiedades();
    }


    public function sendRecibo()
    {


        $data = array(
            'asunto' => $this->asunto,
            'body' => $this->body,
        );

        try {

            $pdfRecibo = new ReciboPagoPdfController();
            $pdfRecibo->sendToMail($this->recibo, $data);
        } catch (Exception $e) {
            dd($e);
            $e->getMessage();
        } finally {

            $this->modalOpenSend = false;
            $this->dispatchBrowserEvent('recibo-send', ['recibo' => $this->recibo]);

            $this->resetPropiedades();
        }
    }
}

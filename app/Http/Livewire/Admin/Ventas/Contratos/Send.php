<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

use App\Http\Controllers\Admin\PDF\ContratoPdfController;
use App\Models\Contratos;
use Exception;
use Livewire\Component;

class Send extends Component
{
    public $modalOpenSend = false;

    public $contrato;

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
        $this->reset('contrato');
    }

    public function render()
    {
        return view('livewire.admin.ventas.contratos.send');
    }

    public function openModal(Contratos $contrato)
    {

        $this->modalOpenSend = true;
        $this->contrato = $contrato;
        $this->to = $contrato->cliente->email . " | " . $contrato->cliente->razon_social;
        $this->asunto = "TALENTUS - CONTRATO " . $contrato->cliente->razon_social;

        // dd($presupuesto);

    }
    public function closeModal()
    {
        $this->modalOpenSend = false;
        $this->resetPropiedades();
    }


    public function sendContrato()
    {

        $data = array(
            'asunto' => $this->asunto,
            'body' => $this->body,
        );

        try {

            $pdfContrato = new ContratoPdfController();
            $pdfContrato->sendToMail($this->contrato, $data);
        } catch (Exception $e) {
            dd($e);
            $e->getMessage();
        } finally {

            $this->modalOpenSend = false;
            $this->dispatchBrowserEvent('contrato-send', ['contrato' => $this->contrato]);

            $this->resetPropiedades();
        }
    }
}

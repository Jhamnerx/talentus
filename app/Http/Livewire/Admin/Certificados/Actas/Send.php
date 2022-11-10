<?php

namespace App\Http\Livewire\Admin\Certificados\Actas;

use App\Http\Controllers\Admin\PDF\ActaPdfController;
use App\Models\Actas;
use Exception;
use Livewire\Component;

class Send extends Component
{

    public $modalOpenSend = false;

    public $acta;
    public $correo;
    public $disabled =  false;

    public $from = "talentus@talentustechnology.com", $to, $asunto = "", $body;

    public $failMsg;

    protected $listeners = [
        'modalOpenSend' => 'openModal'
    ];

    public function render()
    {
        return view('livewire.admin.certificados.actas.send');
    }

    public function resetPropiedades()
    {
        $this->reset('from');
        $this->reset('to');
        $this->reset('asunto');
        $this->reset('body');
        $this->reset('acta');
    }
    public function closeModal()
    {
        $this->modalOpenSend = false;
        $this->resetPropiedades();
    }

    public function openModal(Actas $acta)
    {

        $this->modalOpenSend = true;
        $this->acta = $acta;
        $this->to = $acta->vehiculo->cliente->email . " | " . $acta->vehiculo->cliente->razon_social;
        $this->asunto = "TALENTUS - ACTA #" . $acta->codigo;
        $this->correo =  $acta->vehiculo->cliente->email;

        if (empty($acta->vehiculo->cliente->email)) {

            $this->disabled = true;
        } else {

            $this->disabled = false;
        }
    }

    public function sendActa()
    {
        $data = array(
            'asunto' => $this->asunto,
            'body' => $this->body,
        );

        try {

            $pdfActa = new ActaPdfController();
            $respuesta = $pdfActa->sendToMail($this->acta, $data);
        } catch (Exception $e) {

            $this->failMsg = $e->getMessage();
        } finally {

            //$this->modalOpenSend = false;
            // $this->dispatchBrowserEvent('acta-send', ['acta' => $this->acta]);
            // $this->resetPropiedades();
        }
    }
}

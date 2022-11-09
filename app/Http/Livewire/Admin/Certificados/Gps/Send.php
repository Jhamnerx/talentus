<?php

namespace App\Http\Livewire\Admin\Certificados\Gps;

use App\Http\Controllers\Admin\PDF\CertificadoPdfController;
use App\Models\Certificados;
use Exception;
use Livewire\Component;

class Send extends Component
{
    public $modalOpenSend = false;

    public $certificado;
    public $correo;
    public $disabled =  false;

    public $from = "talentus@talentustechnology.com", $to, $asunto = "", $body;

    public $failMsg;

    protected $listeners = [
        'modalOpenSend' => 'openModal'
    ];

    public function resetPropiedades()
    {
        $this->reset('from');
        $this->reset('to');
        $this->reset('asunto');
        $this->reset('body');
        $this->reset('certificado');
    }

    public function render()
    {
        return view('livewire.admin.certificados.gps.send');
    }

    public function openModal(Certificados $certificado)
    {

        $this->modalOpenSend = true;
        $this->certificado = $certificado;
        $this->to = $certificado->vehiculo->cliente->email . " | " . $certificado->vehiculo->cliente->razon_social;
        $this->asunto = "TALENTUS - CERTIFICADO #" . $certificado->codigo;
        $this->correo =  $certificado->vehiculo->cliente->email;

        if (empty($certificado->vehiculo->cliente->email)) {

            $this->disabled = true;
        } else {

            $this->disabled = false;
        }
    }

    public function closeModal()
    {
        $this->modalOpenSend = false;
        $this->resetPropiedades();
    }

    public function sendCertificado()
    {
        $data = array(
            'asunto' => $this->asunto,
            'body' => $this->body,
        );

        try {

            $pdfCertificado = new CertificadoPdfController();
            $respuesta = $pdfCertificado->sendToMail($this->certificado, $data);
        } catch (Exception $e) {

            $this->failMsg = $e->getMessage();
        } finally {

            $this->modalOpenSend = false;
            $this->dispatchBrowserEvent('certificado-send', ['certificado' => $this->certificado]);
            $this->resetPropiedades();
        }
    }
}

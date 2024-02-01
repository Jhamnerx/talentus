<?php

namespace App\Livewire\Admin\Ventas\Presupuestos;

use App\Http\Controllers\Admin\PDF\PresupuestoPdfController;
use App\Models\Presupuestos;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class Send extends Component
{
    public $modalOpenSend = false;

    public $presupuesto;
    public $correo;
    public $disabled =  false;

    public $from = "talentus@talentustechnology.com", $to, $asunto = "", $body;



    public function resetPropiedades()
    {
        $this->reset('from');
        $this->reset('to');
        $this->reset('asunto');
        $this->reset('body');
        $this->reset('presupuesto');
    }

    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.send');
    }

    #[On('open-modal-send')]
    public function openModal(Presupuestos $presupuesto)
    {

        $this->modalOpenSend = true;
        $this->presupuesto = $presupuesto;
        $this->to = $presupuesto->clientes->email . " | " . $presupuesto->clientes->razon_social;
        $this->asunto = "TALENTUS - COTIZACIÓN #" . $presupuesto->numero;
        $this->correo =  $presupuesto->clientes->email;

        if (empty($presupuesto->clientes->email)) {

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


    public function sendPresupuesto()
    {

        $data = array(
            'asunto' => $this->asunto,
            'body' => $this->body,
        );

        try {

            $pdfPresupuesto = new PresupuestoPdfController();
            $pdfPresupuesto->sendToMail($this->presupuesto, $data);
        } catch (Exception $e) {

            $this->dispatch(
                'error',
                tittle: 'ERROR EN FUNCION: ',
                mensaje: $e->getMessage(),
            );
        } finally {

            $this->modalOpenSend = false;
            $this->dispatch('presupuesto-send', ['presupuesto' => $this->presupuesto]);
            $this->resetPropiedades();
        }
    }
}

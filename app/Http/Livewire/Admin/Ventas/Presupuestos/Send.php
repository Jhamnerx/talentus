<?php

namespace App\Http\Livewire\Admin\Ventas\Presupuestos;

use App\Http\Controllers\Admin\PDF\PresupuestoPdfController;
use App\Models\Presupuestos;
use Exception;
use Livewire\Component;

class Send extends Component
{
    public $modalOpenSend = false;

    public $presupuesto;
    public $correo;
    public $disabled =  false;

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
        $this->reset('presupuesto');
    }

    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.send');
    }

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
        // dd($presupuesto);

    }
    public function closeModal()
    {
        $this->modalOpenSend = false;
        $this->resetPropiedades();
    }


    public function sendPresupuesto()
    {

        //dd($this->presupuesto);
        $data = array(
            'asunto' => $this->asunto,
            'body' => $this->body,
        );
        //dd($this->presupuesto);

        try {

            $pdfPresupuesto = new PresupuestoPdfController();
            $pdfPresupuesto->sendToMail($this->presupuesto, $data);
        } catch (Exception $e) {
            dd($e);
            $e->getMessage();
        } finally {

            $this->modalOpenSend = false;
            $this->dispatchBrowserEvent('presupuesto-send', ['presupuesto' => $this->presupuesto]);
            $this->resetPropiedades();
        }
    }
}

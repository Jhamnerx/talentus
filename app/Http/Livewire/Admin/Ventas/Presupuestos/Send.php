<?php

namespace App\Http\Livewire\Admin\Ventas\Presupuestos;

use App\Http\Controllers\Admin\PDF\PresupuestoPdfController;
use App\Models\Presupuestos;
use Livewire\Component;
use Psy\VarDumper\Presenter;

class Send extends Component
{
    public $modalOpenSend = false;

    public $presupuesto;

    public $from = "talentus@talentustechnology.com", $to, $asunto = "", $body;


    protected $listeners = [
        'modalOpenSend' => 'openModal'
    ];

    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.send');
    }

    public function openModal(Presupuestos $presupuesto){

        $this->modalOpenSend = true;
        $this->presupuesto = $presupuesto;
        $this->to = $presupuesto->clientes->email;
        $this->asunto = "TALENTUS - COTIZACIÓN #".$presupuesto->numero;

       // dd($presupuesto);

    }
    public function closeModal()
    {
        $this->modalOpenSend = false;
        $this->reset();

    }


    public function sendPresupuesto(){

        //dd($this->presupuesto);
        $pdfPresupuesto = new PresupuestoPdfController();
        $pdfPresupuesto->sendToMail($this->presupuesto);

    }

}

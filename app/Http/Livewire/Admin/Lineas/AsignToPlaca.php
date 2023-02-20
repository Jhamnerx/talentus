<?php

namespace App\Http\Livewire\Admin\Lineas;

use App\Models\Lineas;
use App\Models\Vehiculos;
use Livewire\Component;

class AsignToPlaca extends Component
{
    public $openModal = false;

    public $asignado = false, $confirmation = false;

    public Lineas $linea;
    public $vehiculo_id;

    protected $listeners = [
        'asign-to-placa' => 'asignToPlaca'
    ];

    public function render()
    {
        return view('livewire.admin.lineas.asign-to-placa');
    }

    public function asignToPlaca(Lineas $linea)
    {

        $this->asignado = $linea->sim_card->vehiculos ? true : false;

        $this->linea = $linea;

        $this->openModal();
    }

    public function removeLinea()
    {

        $this->confirmation = true;
    }
    public function confirmation()
    {
        $vehiculo = $this->linea->sim_card->vehiculos;
        $vehiculo->numero = NULL;
        $vehiculo->sim_card_id = NULL;
        $vehiculo->old_sim_card = $this->linea->sim_card->sim_card;
        $vehiculo->old_numero = $this->linea->numero;

        if ($vehiculo->save()) {
            $this->asignado = false;
            $this->emit('index-update');
        }
    }

    public function openModal()
    {

        $this->openModal = true;
    }
    public function closeModal()
    {
        $this->openModal = false;
        $this->asignado = false;
        $this->vehiculo_id = null;
    }

    public function asign()
    {

        $vehiculo = Vehiculos::findOrFail($this->vehiculo_id);
        $vehiculo->sim_card_id = $this->linea->sim_card->id;
        $vehiculo->save();

        $this->dispatchBrowserEvent('asign-linea-to-placa', ['placa' => $vehiculo->placa, 'linea' => $this->linea->numero]);
        $this->emit('index-update');
        $this->closeModal();
    }
}

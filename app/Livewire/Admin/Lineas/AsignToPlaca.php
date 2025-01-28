<?php

namespace App\Livewire\Admin\Lineas;

use App\Models\Lineas;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use Livewire\Component;

class AsignToPlaca extends Component
{
    public $openModal = false;

    public $asignado = false, $confirm = false;

    public Lineas $linea;
    public $vehiculo_id;


    public function render()
    {
        return view('livewire.admin.lineas.asign-to-placa');
    }

    #[On('asign-to-placa')]
    public function asignToPlaca(Lineas $linea)
    {

        $this->asignado = $linea->sim_card->vehiculos ? true : false;
        $this->vehiculo_id = $linea->sim_card->vehiculos ? $linea->sim_card->vehiculos->placa : null;

        $this->linea = $linea;

        $this->openModal();
    }

    public function removeLinea()
    {

        $this->confirm = true;
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
            $this->dispatch('pg:eventRefresh-TablaLineas');
        }
        $this->reset('confirm');
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

        $this->afterSave($vehiculo);
    }

    public function afterSave($vehiculo)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'LINEA ASIGNADA A VEHICULO',
            mensaje: 'se asigno la linea: ' . $this->linea->numero . ' a la placa: ' . $vehiculo->placa
        );
        $this->closeModal();
        $this->dispatch('pg:eventRefresh-TablaLineas');
    }
}

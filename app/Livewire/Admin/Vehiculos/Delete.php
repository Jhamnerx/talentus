<?php

namespace App\Livewire\Admin\Vehiculos;

use App\Models\Vehiculos;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public Vehiculos $vehiculo;

    public $modalDelete = false;

    #[On('open-modal-delete')]
    public function openModal(Vehiculos $vehiculo)
    {
        $this->modalDelete = true;
        $this->vehiculo = $vehiculo;
    }

    public function delete()
    {

        if ($this->vehiculo->sim_card) {

            $this->vehiculo->setAttribute('old_numero', $this->vehiculo->numero);
            $this->vehiculo->setAttribute('old_sim_card', $this->vehiculo->sim_card->sim_card);
        }

        $this->vehiculo->setAttribute('old_imei', $this->vehiculo->dispositivo_imei);
        $this->vehiculo->setAttribute('dispositivo_imei', NULL);
        $this->vehiculo->setAttribute('dispositivos_id', NULL);


        $this->vehiculo->setAttribute('numero', NULL);
        $this->vehiculo->setAttribute('sim_card_id', NULL);
        $this->vehiculo->setAttribute('estado', 2);
        $this->vehiculo->save();

        $this->vehiculo->delete();
        $this->afterDelete();
    }


    public function afterDelete()
    {
        $this->closeModal();
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'VEHICULO ELIMINADO',
            mensaje: 'se elimino correctamente el vehiculo'
        );

        $this->dispatch('update-table');
    }

    public function closeModal()
    {

        $this->modalDelete = false;
    }
    public function close()
    {

        $this->closeModal();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.vehiculos.delete');
    }
}

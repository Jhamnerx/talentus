<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use Livewire\Component;
use App\Models\Vehiculos;

class Suspend extends Component
{
    public Vehiculos $vehiculo;

    public $modalSuspend = false;

    protected $listeners = [
        'suspendVehiculo' => 'openModal',
    ];



    public function delete()
    {

        if ($this->vehiculo->numero) {

            $this->vehiculo->setAttribute('old_numero', $this->vehiculo->numero);
            $this->vehiculo->setAttribute('old_sim_card', $this->vehiculo->sim_card->sim_card);
        }



        $this->vehiculo->setAttribute('numero', NULL);
        $this->vehiculo->setAttribute('sim_card_id', NULL);
        $this->vehiculo->setAttribute('estado', 2);
        $this->vehiculo->save();
        // return redirect()->route('admin.vehiculos.index');
        $this->dispatchBrowserEvent('change-status', ['status' => 2]);


        $this->emit('updateTable');
    }



    public function openModal(Vehiculos $vehiculo)
    {
        $this->modalSuspend = true;
        $this->vehiculo = $vehiculo;
    }


    public function render()
    {
        return view('livewire.admin.vehiculos.suspend');
    }
}

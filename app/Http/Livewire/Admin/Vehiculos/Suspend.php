<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use Livewire\Component;
use App\Models\Vehiculos;

class Suspend extends Component
{
    public Vehiculos $vehiculo;

    public $modalSuspend = false;
    public $remove = false;

    protected $listeners = [
        'suspendVehiculo' => 'openModal',
    ];

    public function suspend()
    {

        if ($this->vehiculo->sim_card) {

            $this->vehiculo->setAttribute('old_numero', $this->vehiculo->numero);
            $this->vehiculo->setAttribute('old_sim_card', $this->vehiculo->sim_card->sim_card);
        }

        if ($this->remove) {
            $this->vehiculo->setAttribute('old_imei', $this->vehiculo->dispositivo_imei);
            $this->vehiculo->setAttribute('dispositivo_imei', NULL);
            $this->vehiculo->setAttribute('dispositivos_id', NULL);
        }

        $this->vehiculo->setAttribute('numero', NULL);
        $this->vehiculo->setAttribute('sim_card_id', NULL);
        $this->vehiculo->setAttribute('estado', 2);
        $this->vehiculo->save();
        // return redirect()->route('admin.vehiculos.index');
        $this->dispatchBrowserEvent('change-status', ['status' => 'suspendido']);
        $this->remove = false;
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

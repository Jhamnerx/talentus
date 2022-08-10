<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

use App\Models\Vehiculos;
use Livewire\Component;

class ModalVehiculos extends Component
{
    public $openModalVehiculos = false;
    public $vehiculos;
    public $detalles;


    public function mount()
    {
        $this->vehiculos = Vehiculos::orderBy('id', 'desc')->get();
    }

    public function render()
    {


        return view('livewire.admin.ventas.contratos.modal-vehiculos');
    }
    public function addItemVehiculo(Vehiculos $vehiculo)
    {
        $this->emit('addVehiculo');
        $this->dispatchBrowserEvent('vehiculo-add', ['vehiculo' => $vehiculo, 'plan' => '']);
    }
}

<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

use App\Models\Vehiculos;
use Livewire\Component;

class ItemsVehiculo extends Component
{

    public $items = [];
    public $vehiculos;
    public $i = 0;

    protected $listeners = [
        'addVehiculo'
    ];

    public function render()
    {
        return view('livewire.admin.ventas.contratos.items-vehiculo');
    }

    public function addVehiculo(Vehiculos $vehiculo)
    {
        array_push($this->items, $vehiculo);
    }
}

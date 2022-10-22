<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

use App\Models\Clientes;
use App\Models\Vehiculos;
use Livewire\Component;

class ItemsVehiculo extends Component
{

    // public $items = [];
    // public $vehiculos;
    // public $i = 0;
    //public $panelVehiculosOpen = false;


    public Clientes $cliente;

    protected $listeners = [
        'openPanelVehiculos'
    ];

    public function render()
    {
        return view('livewire.admin.ventas.contratos.items-vehiculo');
    }

    public function openPanelVehiculos(Clientes $cliente)
    {
        $this->cliente = $cliente;
        //dd($cliente);
    }


    public function agregarVehiculo(Vehiculos $vehiculo)
    {

        $this->emit('addVehiculo', $vehiculo);

        //dd($vehiculo);
    }

    // public function addVehiculo(Vehiculos $vehiculo)
    // {
    //     array_push($this->items, $vehiculo);
    // }
}

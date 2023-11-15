<?php

namespace App\Livewire\Admin\Ventas\Contratos;

use App\Models\Clientes;
use App\Models\Vehiculos;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class ItemsVehiculo extends Component
{

    public Clientes $cliente;

    public $search;
    public $vehiculos = [];

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
        $this->vehiculos = $cliente->vehiculos()->get();
    }

    public function updatedSearch($value)
    {
        $this->vehiculos = $this->cliente->vehiculos()->where('placa', 'LIKE', '%' . $this->search . '%')->get();
    }


    public function agregarVehiculo(Vehiculos $vehiculo)
    {
        $this->dispatch('addVehiculo', $vehiculo);
    }

    public function addAll()
    {


        foreach ($this->vehiculos as $vehiculo) {

            $this->dispatch('addVehiculo', $vehiculo);
        }
    }
}

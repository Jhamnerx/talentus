<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

use App\Models\Clientes;
use App\Models\Vehiculos;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class Save extends Component
{
    public $clientes_id, $ciudades_id, $fondo, $sello;
    public $fecha, $vehiculos_id;
    public $panelVehiculosOpen = false;

    public Collection $items;


    protected $listeners = [
        'addVehiculo',
    ];

    public function mount()
    {
        $this->fecha = Carbon::now()->format('Y-m-d');
        $this->items = collect();
    }

    public function render()
    {
        return view('livewire.admin.ventas.contratos.save');
    }


    public function openPanelVehiculos()
    {
        $this->panelVehiculosOpen = true;
    }

    public function updatedClientesId($cliente)
    {

        $this->emit('openPanelVehiculos', $cliente);
    }

    public function addVehiculo(Vehiculos $vehiculo)
    {

        $this->items[$vehiculo->placa] = [
            'vehiculos_id' => $vehiculo->id,
            'placa' => $vehiculo->placa,
            'plan' => 30
        ];
    }

    public function eliminarVehiculo($key)
    {
        unset($this->items[$key]);
        $this->items;
    }

    public function veritems()
    {
        dd($this->items->all());
    }
}

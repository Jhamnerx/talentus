<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

use App\Http\Requests\ContratosRequest;
use App\Models\Contratos;
use App\Models\Vehiculos;
use Livewire\Component;
use Illuminate\Support\Collection;

class Edit extends Component
{
    public Contratos $contrato;

    public $panelVehiculosOpen = false;

    public Collection $items;

    protected $listeners = [
        'addVehiculo',
    ];


    protected $rules = [
        'contrato.clientes_id' => 'required',
        'contrato.ciudades_id' => 'required',
        'contrato.fecha' => 'required',
        'contrato.sello' => 'boolean',
        'contrato.fondo' => 'boolean',

    ];

    public function mount()
    {
        $this->items = collect();
        foreach ($this->contrato->vehiculos as $vehiculo) {
            $this->items[$vehiculo->placa] = [
                'vehiculos_id' => $vehiculo->id,
                'placa' => $vehiculo->placa,
                'plan' => 30
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.ventas.contratos.edit');
    }

    public function openPanelVehiculos()
    {
        $this->panelVehiculosOpen = true;
    }

    public function updatedContratoClientesId($cliente)
    {

        $this->emit('openPanelVehiculos', ['cliente' => $cliente, 'vehiculos' => $cliente->vehiculos]);
    }

    public function eliminarVehiculo($key)
    {
        unset($this->items[$key]);
        $this->items;
    }


    public function addVehiculo(Vehiculos $vehiculo)
    {
        if (array_key_exists($vehiculo->placa, $this->items->all())) {

            $this->dispatchBrowserEvent('error-vehiculo', ['vehiculo' => $vehiculo]);
        } else {


            $this->dispatchBrowserEvent('add-vehiculo', ['vehiculo' => $vehiculo]);

            $this->items[$vehiculo->placa] = [
                'vehiculos_id' => $vehiculo->id,
                'placa' => $vehiculo->placa,
                'plan' => 30
            ];
        }
    }

    public function veritems()
    {

        dd(array_key_exists('M7N-710', $this->items->all()));
    }
    // public function updated($field)
    // {

    //     $request = new ContratosRequest();
    //     $this->validateOnly($field, $request->rules(), $request->messages());
    // }
}

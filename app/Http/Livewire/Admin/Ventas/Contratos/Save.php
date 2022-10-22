<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

use App\Http\Requests\ContratosRequest;
use App\Models\Clientes;
use App\Models\Contratos;
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

    public function eliminarVehiculo($key)
    {
        unset($this->items[$key]);
        $this->items;
    }

    public function veritems()
    {

        dd(array_key_exists('M7N-710', $this->items->all()));
    }


    public function save()
    {
        $request = new ContratosRequest();

        $validate = $this->validate($request->rules(), $request->messages());
        $contrato = Contratos::create([
            'clientes_id' => $validate["clientes_id"],
            'fecha' => $validate["fecha"],
            'sello' => $validate["sello"],
            'fondo' => $validate["fondo"],
            'ciudades_id' => $validate["ciudades_id"],
        ]);

        Contratos::createItems($contrato, $validate["items"]);


        return redirect()->route('admin.ventas.contratos.index')->with('store', 'El contrato de guardo con exito');
    }

    public function updated($field)
    {

        $request = new ContratosRequest();
        $this->validateOnly($field, $request->rules(), $request->messages());
    }
}

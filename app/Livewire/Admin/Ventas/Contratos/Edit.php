<?php

namespace App\Livewire\Admin\Ventas\Contratos;


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
        'items' => 'array|between:1,100',
        'items.*.plan' => 'required|integer',
        'items.*.placa' => 'required',
        'items.*.vehiculos_id' => 'required',
    ];

    protected $messages = [
        'contrato.clientes_id.required' => 'Debes Seleccionar un Cliente',
        'contrato.fecha.required' => 'Selecciona una fecha',
        'ciudades_id.required' => 'Debe seleccionar una ciudad',
        'items.*.plan.required' => 'Ingresa un plan valido',
        'items.*.plan.integer' => 'No puedes ingresar letras aqui',
        'items.array' => 'Ingresa como minimo un vehiculo',
        'items.between' => 'Ingresa como minimo un vehiculo'
    ];

    public function mount($contrato)
    {
        $this->items = collect();

        foreach ($this->contrato->detalle as $detalle) {
            $this->items[$detalle->vehiculos->placa] = [
                'vehiculos_id' => $detalle->vehiculos->id,
                'placa' => $detalle->vehiculos->placa,
                'plan' => $detalle->plan
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

        $this->dispatch('openPanelVehiculos', ['cliente' => $cliente, 'vehiculos' => $cliente->vehiculos]);
    }

    public function eliminarVehiculo($key)
    {
        unset($this->items[$key]);
        $this->items;
    }


    public function addVehiculo(Vehiculos $vehiculo)
    {
        if (array_key_exists($vehiculo->placa, $this->items->all())) {

            $this->dispatch('error-vehiculo', ['vehiculo' => $vehiculo]);
        } else {


            $this->dispatch('add-vehiculo', ['vehiculo' => $vehiculo]);

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



    public function updated($field)
    {
        $this->validateOnly($field);
    }
    public function save()
    {

        $this->validate();

        $this->contrato->save();

        $this->contrato->detalle()->delete();

        Contratos::createItems($this->contrato, $this->items);

        return redirect()->route('admin.ventas.contratos.index')->with('update', 'El contrato de actualizo con exito');
    }
}

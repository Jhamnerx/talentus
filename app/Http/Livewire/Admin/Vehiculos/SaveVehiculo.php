<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use App\Http\Requests\VehiculosRequest;
use App\Models\Clientes;
use App\Models\Flotas;
use App\Models\Vehiculos;
use Livewire\Component;

class SaveVehiculo extends Component
{
    public $data;


    public $clientes_id;
    public $placa, $marca, $modelo, $tipo, $year, $color, $motor, $serie, $numero, $operador, $sim_card, $sim_card_id, $modelo_gps, $dispositivo_imei, $dispositivos_id, $descripcion;
    public $empresa_id;
    public $modalOpen = false;

    protected $listeners = [
        'openModalSave',
    ];


    public function mount()
    {
        $this->empresa_id = session('empresa');

        $querys = Flotas::all();

        $flotas = [];
        //$data = [];
        foreach ($querys as $query) {

            $flotas[$query->id] = $query->nombre;
        }
        $this->data = $flotas;
    }

    public function render()
    {
        return view('livewire.admin.vehiculos.save-vehiculo');
    }

    public function openModal()
    {

        $this->modalOpen = true;
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();
    }

    public function GuardarVehiculo()
    {
        $requestVehiculo = new VehiculosRequest();

        $validatedDate = $this->validate($requestVehiculo->rules($this->dispositivos_id, $this->numero), $requestVehiculo->messages());

        Vehiculos::create($validatedDate);

        $this->emit('updateTable');
        $this->modalOpen = false;

        return redirect()->route('admin.vehiculos.index')->with('flash.banner', 'El vehiculo fue creado');
        return redirect()->route('admin.vehiculos.index')->with('flash.bannerStyle', 'success');
    }

    public function updated($label)
    {
        $requestVehiculo = new VehiculosRequest();
        $this->validateOnly($label, $requestVehiculo->rules($this->dispositivos_id, $this->numero), $requestVehiculo->messages());
        //dd($label);
    }

    public function openModalSave()
    {

        $this->modalOpen = true;
    }

    public function updatedClientesId($cliente)
    {

        dd($cliente);
    }
}

<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use App\Http\Requests\VehiculosRequest;
use App\Models\Flotas;
use App\Models\Vehiculos;
use Livewire\Component;

class SaveVehiculo extends Component
{
    public $data;
    public $placa, $marca, $modelo, $tipo, $year, $color, $motor, $serie, $flotas_id, $numero, $operador, $sim_card, $sim_card_id, $modelo_gps, $imei, $dispositivos_id, $descripcion;
    public $empresa_id;
    public $modalOpen = false;


    protected  $rules = [
        'placa' => 'required|unique:vehiculos',
        "marca" => 'nullable',
        "modelo" => 'nullable',
        "tipo" => 'nullable',
        "year" => 'nullable',
        "color" => 'nullable',
        "motor" => 'nullable',
        "serie" => 'nullable',
        "sim_card_id" => 'nullable',
        "numero" => "required",
        "flotas_id"  => "required",
        "dispositivos_id" => 'nullable|unique:vehiculos',
        "empresa_id" => 'exists:empresas,id',
        "modelo_gps" => 'nullable',
        "operador" => 'nullable',
        "sim_card" => 'nullable',
        "imei" => 'nullable',
        "descripcion" => 'nullable',

        // "dispositivos_id" => "required|unique:vehiculos",

    ];

    protected $messages = [
        'placa.required' => 'La placa es requerida',
        'placa.unique' => 'Esta placa ya esta registrada',
        'flotas_id.required' => 'Debe seleccionar una flota',
        'numero.required' => 'El numero es requerido',
        'numero.unique' => 'ya estas registrando este sim',
        'dispositivos_id.required' => 'El imei es requerido',
        'dispositivos_id.unique' => 'Este imei ya esta registrado',

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

        //$data['data'] = $flotas;



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
        return redirect()->route('admin.vehiculos.index')->with('flash.abnnerStyle', 'success');
        // return redirect()->route('admin.almacen.lineas.index')->with('store', 'Se guardo con exito');
    }

    public function updated($label)
    {
        $requestVehiculo = new VehiculosRequest();
        $this->validateOnly($label, $requestVehiculo->rules($this->dispositivos_id, $this->numero), $requestVehiculo->messages());
        //dd($label);
    }
}

<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use App\Models\Flotas;
use Livewire\Component;

class SaveVehiculo extends Component
{
    public $data;
    public $placa, $marca, $modelo, $tipo, $year, $color, $motor, $serie, $flotas_id, $numero, $dispositivos_id, $descripcion;
    public $modalOpen = false;


    protected $rules = [

        'placa' => 'required|unique:vehiculos',
        "flotas_id"  => "required",
        "numero" => "required|unique:vehiculos",
        "dispositivos_id" => "required|unique:vehiculos",

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
    }

    public function save()
    {
        //dd($this->sim_card_n);
        $validatedDate = $this->validate();




        // SimCard::create([
        //     'sim_card' => $this->sim_card_n[$key],
        //     'operador' => $this->operador[$key],
        //     'empresa_id' => $this->empresa_id,
        // ]);

        // return redirect()->route('admin.almacen.lineas.index')->with('store', 'Se guardo con exito');
    }
}

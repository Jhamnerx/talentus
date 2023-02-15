<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use App\Http\Requests\VehiculosRequest;
use App\Models\Clientes;
use App\Models\Dispositivos;
use App\Models\Flotas;
use App\Models\Vehiculos;
use Livewire\Component;

class SaveVehiculo extends Component
{
    public $flotas;


    public $clientes_id;
    public $placa, $marca, $modelo, $tipo, $year, $color, $motor, $serie, $numero, $operador, $sim_card, $sim_card_id, $modelo_gps, $dispositivo_imei, $dispositivos_id, $descripcion;
    public $empresa_id;
    public $modalOpen = false;

    protected $listeners = [
        'openModalSave',
    ];


    public function mount()
    {
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


        $this->setDispositivoVendido($validatedDate['dispositivo_imei']);

        $this->emit('updateTable');
        $this->modalOpen = false;

        //return redirect()->route('admin.vehiculos.index')->with('flash.banner', 'El vehiculo fue creado');
        //return redirect()->route('admin.vehiculos.index')->with('flash.bannerStyle', 'success');
    }
    public function setDispositivoVendido($imei)
    {

        $dispositivo = Dispositivos::where('imei', $imei)->firstOrFail();
        if ($dispositivo) {
            $dispositivo->estado = "VENDIDO";
            $dispositivo->save();
        }
    }

    public function updated($label)
    {
        $requestVehiculo = new VehiculosRequest();
        $this->validateOnly($label, $requestVehiculo->rules($this->dispositivos_id, $this->numero), $requestVehiculo->messages());
    }

    public function openModalSave()
    {

        $this->modalOpen = true;
    }

    public function updatedClientesId($value)
    {

        $this->flotas = Clientes::find($value)->flotas()->get();
    }
}

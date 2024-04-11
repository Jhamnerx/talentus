<?php

namespace App\Livewire\Admin\Vehiculos;

use App\Models\Flotas;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use App\Models\Dispositivos;
use App\Http\Requests\VehiculosRequest;
use App\Models\Lineas;

class SaveVehiculo extends Component
{
    public $flotas;

    public $placa, $marca, $modelo, $tipo, $year, $color, $motor, $serie, $dispositivo_imei = '', $modelo_gps,
        $sim_card_id, $numero, $sim_card, $operador, $clientes_id, $dispositivos_id, $descripcion;

    public $modalSaveV = false;

    public $flotas_selected = [];

    public function render()
    {
        return view('livewire.admin.vehiculos.save-vehiculo');
    }


    #[On('open-modal-save')]
    public function openModalSave($placa = null)
    {

        $this->modalSaveV = true;
        $this->placa = $placa;
    }


    public function closeModal()
    {
        $this->modalSaveV = false;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function save()
    {
        $requestVehiculo = new VehiculosRequest();

        $data = $this->validate($requestVehiculo->rules($this->dispositivos_id, $this->numero), $requestVehiculo->messages());


        try {

            $vehiculo = Vehiculos::create($data);
            $this->registerFlotas($vehiculo);

            $this->setDispositivoVendido($data['dispositivo_imei']);
            $this->dispatch('update-table');

            $this->afterSave($data["placa"]);
        } catch (\Throwable $th) {

            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }


    public function registerFlotas(Vehiculos $vehiculo)
    {

        $vehiculo->flotas()->attach($this->flotas_selected);
    }

    public function afterSave($placa)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'VEHICULO REGISTRADO',
            mensaje: 'Se registro correctamente el vehiculo ' . $placa,
        );
        $this->closeModal();
        $this->reset();
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


    public function updatedClientesId($value)
    {

        if ($value) {

            $this->flotas = Clientes::find($value)->flotas()->get();
        } else {
            $this->reset('flotas');
        }
    }

    public function updatedNumero($numero)
    {

        if ($numero) {

            $linea = Lineas::where('numero', $numero)->first();
            $this->operador = $linea->operador;
            $this->sim_card_id = $linea->sim_card ? $linea->sim_card->id : null;
            $this->sim_card = $linea->sim_card ? $linea->sim_card->sim_card : null;
        }
    }

    public function updatedPlaca()
    {
        $this->placa = strtoupper($this->placa);
    }

    public function updatedDispositivoImei($imei = '')
    {

        if ($imei) {
            $dispositivo = Dispositivos::where('imei', $imei)->first();
            $this->dispositivos_id = $dispositivo->id;
            $this->modelo_gps = $dispositivo->modelo->modelo;
        }
    }

    public function close()
    {
        $this->closeModal();
        $this->reset();
    }

    public function addLinea($numero)
    {
        $this->dispatch('add-linea-modal', numero: $numero);
    }

    public function registarImei($imei)
    {
        $this->dispatch('add-imei-modal', imei: $imei);
    }

    public function OpenModalCliente($busqueda)
    {

        $this->dispatch('open-modal-save-cliente', busqueda: $busqueda);
    }
}

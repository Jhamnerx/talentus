<?php

namespace App\Livewire\Admin\Vehiculos;

use App\Models\Lineas;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use App\Models\Dispositivos;
use App\Http\Requests\VehiculosRequest;

class EditVehiculo extends Component
{
    public $flotas;

    public $placa, $marca, $modelo, $tipo, $year, $color, $motor, $serie, $dispositivo_imei, $modelo_gps,
        $sim_card_id, $numero, $sim_card, $operador, $clientes_id, $dispositivos_id, $descripcion;

    public $modalEdit = false;

    public $flotas_selected = [];


    public Vehiculos $vehiculo;

    public function render()
    {
        return view('livewire.admin.vehiculos.edit-vehiculo');
    }


    #[On('open-modal-edit')]
    public function openModalEdit(Vehiculos $vehiculo)
    {

        $this->modalEdit = true;
        $this->vehiculo = $vehiculo;
        $this->placa = $vehiculo->placa;
        $this->marca = $vehiculo->marca;
        $this->modelo = $vehiculo->modelo;
        $this->tipo = $vehiculo->tipo;
        $this->year = $vehiculo->year;
        $this->color = $vehiculo->color;
        $this->motor = $vehiculo->motor;
        $this->serie = $vehiculo->serie;
        $this->dispositivo_imei = $vehiculo->dispositivo_imei;
        $this->modelo_gps = $vehiculo->dispositivos ? $vehiculo->dispositivos->modelo->modelo : null;
        $this->sim_card_id = $vehiculo->sim_card_id;
        $this->numero = $vehiculo->numero;
        $this->sim_card = $vehiculo->sim_card ? $vehiculo->sim_card->sim_card : null;
        $this->operador = $vehiculo->sim_card ? $vehiculo->sim_card->operador : null;
        $this->clientes_id = $vehiculo->clientes_id;
        $this->dispositivos_id = $vehiculo->dispositivos_id;
        $this->descripcion = $vehiculo->descripcion;
    }
    public function save()
    {
        $requestVehiculo = new VehiculosRequest();
        $data = $this->validate($requestVehiculo->rules($this->dispositivos_id, $this->numero, $this->vehiculo), $requestVehiculo->messages());


        try {


            $this->vehiculo->update($data);

            $changes =  $this->vehiculo->getChanges();

            $this->registerFlotas($this->vehiculo);
            $this->setDispositivoVendido($data['dispositivo_imei']);
            $this->dispatch('update-table');

            if (array_key_exists('numero', $changes)) {

                $this->closeModal();
                $this->dispatch(
                    'updated-numero',
                    placa: $data["placa"],
                );

                $this->reset();
            } else {

                $this->afterSave($data["placa"]);
            }
        } catch (\Throwable $th) {

            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function setDispositivoVendido($imei)
    {

        $dispositivo = Dispositivos::where('imei', $imei)->firstOrFail();
        if ($dispositivo) {
            $dispositivo->estado = "VENDIDO";
            $dispositivo->save();
        }
    }

    public function registerFlotas(Vehiculos $vehiculo)
    {

        $vehiculo->flotas()->sync($this->flotas_selected);
    }


    public function afterSave($placa)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'VEHICULO ACTUALIZADO',
            mensaje: 'Se registro correctamente el vehiculo ' . $placa,
        );
        $this->closeModal();
        $this->reset();
    }

    public function closeModal()
    {
        $this->modalEdit = false;
        $this->resetErrorBag();
        $this->resetValidation();
    }



    public function updated($label)
    {
        $requestVehiculo = new VehiculosRequest();
        $this->validateOnly($label, $requestVehiculo->rules($this->dispositivos_id, $this->numero), $requestVehiculo->messages());
    }


    public function convertirAMayusculas()
    {
        $this->placa = strtoupper($this->placa);
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
    public function updatedDispositivoImei($imei)
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

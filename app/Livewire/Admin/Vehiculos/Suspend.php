<?php

namespace App\Livewire\Admin\Vehiculos;

use Livewire\Component;
use App\Models\Vehiculos;
use Livewire\Attributes\On;

class Suspend extends Component
{
    public Vehiculos $vehiculo;

    public $modalSuspend = false;
    public $remove = false;

    public function suspend()
    {
        if ($this->vehiculo->sim_card) {
            $this->vehiculo->setAttribute('old_numero', $this->vehiculo->numero);
            $this->vehiculo->setAttribute('old_sim_card', $this->vehiculo->sim_card->sim_card);
        }

        // Si el vehículo tiene un dispositivo asociado
        if ($this->vehiculo->dispositivo_imei && $this->vehiculo->dispositivos_id) {
            // Registrar fecha de desinstalación en vehiculos_dispositivos
            $vehiculoDispositivo = \App\Models\VehiculoDispositivos::where('vehiculo_id', $this->vehiculo->id)
                ->where('dispositivo_id', $this->vehiculo->dispositivos_id)
                ->whereNull('fecha_desinstalacion')
                ->latest('fecha_instalacion')
                ->first();

            if ($vehiculoDispositivo) {
                $vehiculoDispositivo->fecha_desinstalacion = now();
                if ($this->remove) {
                    $vehiculoDispositivo->is_principal = false; // Marcar como no principal si se está removiendo
                }
                $vehiculoDispositivo->save();
            }
            // Cambiar estado del dispositivo a STOCK
            $dispositivo = \App\Models\Dispositivos::find($this->vehiculo->dispositivos_id);
            if ($dispositivo) {
                $dispositivo->estado = \App\Models\Dispositivos::STOCK;
                $dispositivo->save();
            }
        }

        if ($this->remove) {
            $this->vehiculo->setAttribute('old_imei', $this->vehiculo->dispositivo_imei);
            $this->vehiculo->setAttribute('dispositivo_imei', NULL);
            $this->vehiculo->setAttribute('dispositivos_id', NULL);
        }

        $this->vehiculo->setAttribute('numero', NULL);
        $this->vehiculo->setAttribute('sim_card_id', NULL);
        $this->vehiculo->setAttribute('estado', 2);
        $this->vehiculo->save();
        // return redirect()->route('admin.vehiculos.index');

        $this->afterSuspend($this->vehiculo->placa);
    }


    #[On('open-modal-suspend-vehiculo')]
    public function openModal(Vehiculos $vehiculo)
    {
        $this->modalSuspend = true;
        $this->vehiculo = $vehiculo;
    }

    public function afterSuspend($placa)
    {

        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'VEHICULO SUSPENDIDO',
            mensaje: 'se suspendio el vehiculo: ' . $placa,
        );

        $this->remove = false;
        $this->dispatch('update-table');
    }


    public function render()
    {
        return view('livewire.admin.vehiculos.suspend');
    }
}

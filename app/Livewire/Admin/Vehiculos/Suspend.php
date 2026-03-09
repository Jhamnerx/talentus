<?php

namespace App\Livewire\Admin\Vehiculos;

use Livewire\Component;
use App\Models\Actas;
use App\Models\Vehiculos;
use App\Models\DetalleCobros;
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

        // Desinstalar TODOS los dispositivos activos del vehículo
        $vehiculoDispositivos = \App\Models\VehiculoDispositivos::where('vehiculo_id', $this->vehiculo->id)
            ->whereNull('fecha_desinstalacion')
            ->get();

        foreach ($vehiculoDispositivos as $vd) {
            $vd->fecha_desinstalacion = now();
            if ($this->remove) {
                $vd->is_principal = false;
            }
            $vd->save();
        }

        if ($this->remove) {
            $this->vehiculo->setAttribute('old_imei', $this->vehiculo->dispositivo_imei);
            $this->vehiculo->setAttribute('dispositivo_imei', null);
            $this->vehiculo->setAttribute('dispositivos_id', null);
        }

        $this->vehiculo->setAttribute('numero', NULL);
        $this->vehiculo->setAttribute('sim_card_id', NULL);
        $this->vehiculo->setAttribute('estado', 2);
        $this->vehiculo->save();

        // Cancelar suscripción del paquete laravelcm/laravel-subscriptions
        $subscription = $this->vehiculo->planSubscription('gps-tracking');
        $subscription?->cancel(immediately: true);

        // Marcar DetalleCobros activos como inactivo (estado = false)
        DetalleCobros::where('vehiculo_id', $this->vehiculo->id)
            ->where('estado', true)
            ->update(['estado' => false]);

        // Anular la última acta activa del vehículo
        $ultimaActa = Actas::where('vehiculos_id', $this->vehiculo->id)
            ->where('estado', 1)
            ->latest()
            ->first();
        if ($ultimaActa) {
            $ultimaActa->estado = 0;
            $ultimaActa->save();
        }

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
        $this->modalSuspend = false;
        $this->remove = false;

        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'VEHICULO SUSPENDIDO',
            mensaje: 'se suspendio el vehiculo: ' . $placa,
        );

        $this->dispatch('update-table');
    }


    public function render()
    {
        return view('livewire.admin.vehiculos.suspend');
    }
}

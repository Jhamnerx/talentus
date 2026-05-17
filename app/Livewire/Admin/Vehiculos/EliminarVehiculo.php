<?php

namespace App\Livewire\Admin\Vehiculos;

use App\Models\Vehiculos;
use Livewire\Attributes\On;
use Livewire\Component;

class EliminarVehiculo extends Component
{
    public Vehiculos $vehiculo;
    public $mostrarModal = false;

    #[On('open-modal-delete')]
    public function abrirModal(Vehiculos $vehiculo)
    {
        $this->mostrarModal = true;
        $this->vehiculo = $vehiculo;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function eliminar()
    {
        if ($this->vehiculo->sim_card) {
            $this->vehiculo->setAttribute('old_numero', $this->vehiculo->numero);
            $this->vehiculo->setAttribute('old_sim_card', $this->vehiculo->sim_card->sim_card);
        }

        // Marcar todos los dispositivos activos como desinstalados
        \App\Models\VehiculoDispositivos::where('vehiculo_id', $this->vehiculo->id)
            ->whereNull('fecha_desinstalacion')
            ->update(['fecha_desinstalacion' => now(), 'is_principal' => false]);

        $this->vehiculo->setAttribute('dispositivos_id', NULL);
        $this->vehiculo->setAttribute('numero', NULL);
        $this->vehiculo->setAttribute('sim_card_id', NULL);
        $this->vehiculo->setAttribute('estado', 2);
        $this->vehiculo->save();

        $this->vehiculo->delete();
        $this->afterDelete();
    }

    public function afterDelete()
    {
        $this->cerrarModal();
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'VEHICULO ELIMINADO',
            mensaje: 'se elimino correctamente el vehiculo'
        );
        $this->dispatch('update-table');
    }

    public function render()
    {
        return view('livewire.admin.vehiculos.eliminar-vehiculo');
    }
}

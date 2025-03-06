<?php

namespace App\Livewire\Admin\Cobros;

use App\Models\Cobros;
use App\Models\DetalleCobros;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalSuspend extends Component
{
    public $openModal = false;
    public $detalle;


    public function render()
    {
        return view('livewire.admin.cobros.modal-suspend');
    }

    #[On('suspend-vehiculo-cobro')]
    public function openModalSuspend(DetalleCobros $detalle)
    {
        $this->openModal = true;
        $this->detalle = $detalle;
    }

    public function SuspendCobro()
    {
        $this->detalle->estado = 0;
        $this->detalle->save();

        $vehiculo = Vehiculos::find($this->detalle->vehiculo_id);
        $vehiculo->is_active = 0;
        $vehiculo->save();

        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'VEHICULO SUSPENDIDO',
            mensaje: 'Se suspendio el vehiculo correctamente'
        );

        $this->dispatch('update-cobros');
    }
}

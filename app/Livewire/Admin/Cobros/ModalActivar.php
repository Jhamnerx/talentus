<?php

namespace App\Livewire\Admin\Cobros;

use App\Models\Cobros;
use App\Models\DetalleCobros;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalActivar extends Component
{
    public $openModal = false;
    public $detalle;

    public function render()
    {
        return view('livewire.admin.cobros.modal-activar');
    }

    #[On('activar-vehiculo-cobro')]
    public function openModal(DetalleCobros $detalle)
    {

        $this->openModal = true;
        $this->detalle = $detalle;
    }

    public function ActivarCobro()
    {
        $this->detalle->estado = 1;
        $this->detalle->save();

        $vehiculo = Vehiculos::find($this->detalle->vehiculo->id);
        $vehiculo->is_active = 1;
        $vehiculo->save();

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'VEHICULO ACTIVADO',
            mensaje: 'Se activo el vehiculo correctamente'
        );
        $this->dispatch('update-cobros');
    }
}

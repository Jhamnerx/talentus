<?php

namespace App\Livewire\Admin\Cobros;

use App\Models\Cobros;
use Livewire\Component;
use App\Models\DetalleCobros;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;

class Suspend extends Component
{
    public $observacion;

    public $detalle;

    public function mount($detalle)
    {
        $this->observacion = $detalle->observacion;
        $this->detalle = $detalle;
    }


    public function render()
    {
        return view('livewire.admin.cobros.suspend');
    }

    public function openModalSuspend(DetalleCobros $detalle)
    {
        $this->dispatch('suspend-vehiculo-cobro', detalle: $this->detalle);
    }

    public function openModalActivar()
    {

        $this->dispatch('activar-vehiculo-cobro', detalle: $this->detalle);
    }

    public function guardarObservacion()
    {
        $this->detalle->observacion = $this->observacion;
        $this->detalle->save();
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'OBSERVACION GUARDADA',
            mensaje: 'Se guardo la observacion correctamente'
        );
    }

    #[On('update-cobros')]
    public function updateSuspend()
    {
        $this->render();
    }
}

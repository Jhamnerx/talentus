<?php

namespace App\Http\Livewire\Admin\Cobros;

use App\Models\Cobros;
use App\Models\Vehiculos;
use Livewire\Component;

class ModalSuspend extends Component
{
    public $openModalSuspend = false;
    public $cobro, $observacion;
    protected $listeners = [

        'suspendCobro' => 'openModalSuspend',
    ];

    public function render()
    {
        return view('livewire.admin.cobros.modal-suspend');
    }

    public function openModalSuspend(Cobros $cobro, $observacion)
    {
        $this->openModalSuspend = true;
        $this->cobro = $cobro;
        $this->observacion = $observacion;
    }

    public function SuspendCobro()
    {
        $this->cobro->observacion = $this->observacion;
        $this->cobro->suspendido = 1;
        $this->cobro->save();

        $vehiculo = Vehiculos::find($this->cobro->vehiculo->id);
        $vehiculo->is_active = 0;
        $vehiculo->save();

        //return redirect()->route('admin.cobros.show', $this->cobro)->with('suspend', 'Se suspendio el servicio');
        session()->flash('flash.banner', 'Se suspendio el servicio');
        session()->flash('flash.bannerStyle', 'danger');

        return redirect()->route('admin.cobros.show', $this->cobro);
    }
}

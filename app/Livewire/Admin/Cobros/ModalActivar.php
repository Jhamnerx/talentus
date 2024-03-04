<?php

namespace App\Livewire\Admin\Cobros;

use App\Models\Cobros;
use App\Models\Vehiculos;
use Livewire\Component;

class ModalActivar extends Component
{
    public $openModalActivar = false;
    public $cobro;

    protected $listeners = [

        'activarCobro' => 'openModalActivar',
    ];

    public function render()
    {
        return view('livewire.admin.cobros.modal-activar');
    }

    public function openModalActivar(Cobros $cobro)
    {

        $this->openModalActivar = true;
        $this->cobro = $cobro;
    }
    public function ActivarCobro()
    {
        $this->cobro->suspendido = 0;
        $this->cobro->save();

        $vehiculo = Vehiculos::find($this->cobro->vehiculo->id);
        $vehiculo->is_active = 1;
        $vehiculo->save();


        session()->flash('flash.banner', 'Se activo el servicio');
        session()->flash('flash.bannerStyle', 'green');

        return redirect()->route('admin.cobros.show', $this->cobro);
    }
}

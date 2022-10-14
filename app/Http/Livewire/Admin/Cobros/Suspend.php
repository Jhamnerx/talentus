<?php

namespace App\Http\Livewire\Admin\Cobros;

use App\Models\Cobros;
use Livewire\Component;

class Suspend extends Component
{
    public $observacion;
    public $cobro;
    public $openModalSuspend = false;
    public $openModalActivar = false;

    public function mount(Cobros $cobro)
    {
        $this->observacion = $cobro->observacion;
        $this->cobro = $cobro;
    }


    public function render()
    {
        return view('livewire.admin.cobros.suspend');
    }

    public function openModalSuspend()
    {

        $this->emit('suspendCobro', $this->cobro, $this->observacion);
        $this->openModalSuspend = true;
        //dd($this->cobro);
    }

    public function openModalActivar()
    {

        $this->emit('activarCobro', $this->cobro);
        $this->openModalActivar = true;
    }
}

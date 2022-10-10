<?php

namespace App\Http\Livewire\Admin\Cobros;

use App\Models\Cobros;
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
}

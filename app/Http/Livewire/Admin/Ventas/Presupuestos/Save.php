<?php

namespace App\Http\Livewire\Admin\Ventas\Presupuestos;

use App\Http\Controllers\Admin\UtilesController;
use Livewire\Component;

class Save extends Component
{
    public $tipoCambio =  0.00;

    public function mount(){

         $this->tipoCambio = UtilesController::tipoCambio();

    }

    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.save');
    }
}

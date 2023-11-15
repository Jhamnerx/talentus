<?php

namespace App\Livewire\Admin\Ventas\Presupuestos;

use App\Models\Clientes;
use Livewire\Component;

class Select extends Component
{
    public $data;

    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.select');
    }

    public function mount()
    {
        $querys = Clientes::all();

        $clientes = [];
        //$data = [];


        foreach ($querys as $query) {

            $clientes[$query->id] = $query->razon_social;
        }

        //$data['data'] = $clientes;



        $this->data = $clientes;
    }
}

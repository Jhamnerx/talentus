<?php

namespace App\Http\Livewire\Admin\Cobros;

use App\Models\Clientes;
use App\Models\Cobros;
use Livewire\Component;

class ClientesList extends Component
{


    public Clientes $cliente;

    public function render()
    {

        return view('livewire.admin.cobros.clientes-list');
    }
}

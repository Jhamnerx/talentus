<?php

namespace App\View\Components\Admin\Ventas;

use App\Models\Clientes;
use Illuminate\View\Component;

class ClienteSelected extends Component
{


    public function __construct(public Clientes $cliente)
    {
    }

    public function render()
    {
        return view('components.admin.ventas.cliente-selected');
    }
}

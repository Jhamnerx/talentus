<?php

namespace App\View\Components\Admin\Ventas\Facturas;

use Illuminate\View\Component;

class TableCredito extends Component
{
    public $cuotas;
    public function __construct($cuotas)
    {
        $this->cuotas = $cuotas;
        //
    }

    public function render()
    {
        return view('components.admin.ventas.facturas.table-credito');
    }
}

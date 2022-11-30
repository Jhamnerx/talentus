<?php

namespace App\View\Components\Admin\Ventas;

use Illuminate\View\Component;

class TablaDetalleVenta extends Component
{

    public $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('components.admin.ventas.tabla-detalle-venta');
    }
}

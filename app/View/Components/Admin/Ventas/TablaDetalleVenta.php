<?php

namespace App\View\Components\Admin\Ventas;

use Illuminate\View\Component;

class TablaDetalleVenta extends Component
{

    public $items;
    public $selected;

    public function __construct($items, $selected)
    {
        $this->items = $items;
        $this->selected = $selected;
    }

    public function render()
    {
        return view('components.admin.ventas.tabla-detalle-venta');
    }
}

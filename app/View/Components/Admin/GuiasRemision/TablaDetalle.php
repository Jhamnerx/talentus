<?php

namespace App\View\Components\Admin\GuiasRemision;

use Illuminate\View\Component;

class TablaDetalle extends Component
{

    public function __construct(public $items)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.guias-remision.tabla-detalle');
    }
}

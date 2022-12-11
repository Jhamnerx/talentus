<?php

namespace App\View\Components\Admin\GuiasRemision;

use Illuminate\View\Component;

class ListaImei extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $imei_list, $imeis_add;
    public function __construct($imeis, $imeisadd)
    {
        $this->imei_list = $imeis;
        $this->imeis_add = $imeisadd;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.guias-remision.lista-imei');
    }
}

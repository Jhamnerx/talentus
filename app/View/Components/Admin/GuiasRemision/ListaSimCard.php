<?php

namespace App\View\Components\Admin\GuiasRemision;

use Illuminate\View\Component;

class ListaSimCard extends Component
{
    public $sim_list, $sim_add;
    public function __construct($sims, $simadd)
    {
        $this->sim_list = $sims;
        $this->sim_add = $simadd;
    }

    public function render()
    {
        return view('components.admin.guias-remision.lista-sim-card');
    }
}

<?php

namespace App\View\Components\Admin\Tecnico\Tareas;

use Illuminate\View\Component;

class TablaHistorial extends Component
{

    public function __construct(public $tareas)
    {
        //
    }

    public function render()
    {
        return view('components.admin.tecnico.tareas.tabla-historial');
    }
}

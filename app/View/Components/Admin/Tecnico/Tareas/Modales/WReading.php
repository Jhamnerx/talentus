<?php

namespace App\View\Components\Admin\Tecnico\Tareas\Modales;

use Illuminate\View\Component;

class WReading extends Component
{

    public function __construct(public $tareas)
    {
        //
    }

    public function render()
    {
        return view('components.admin.tecnico.tareas.modales.w-reading');
    }
}

<?php

namespace App\View\Components\Admin\Tecnico\Tareas\Modales;

use Illuminate\View\Component;

class TableComplete extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $tareas)
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
        return view('components.admin.tecnico.tareas.modales.table-complete');
    }
}

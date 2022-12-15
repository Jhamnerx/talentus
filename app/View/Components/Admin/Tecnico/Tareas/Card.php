<?php

namespace App\View\Components\Admin\Tecnico\Tareas;

use Illuminate\View\Component;

class Card extends Component
{

    public function __construct(public $colorInitial, public $colorFinal, public $cantidad)
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
        return view('components.admin.tecnico.tareas.card');
    }
}

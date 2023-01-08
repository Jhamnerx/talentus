<?php

namespace App\View\Components\Admin\Gerencia\Reportes;

use Illuminate\View\Component;

class Cards extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
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
        return view('components.admin.gerencia.reportes.cards');
    }
}

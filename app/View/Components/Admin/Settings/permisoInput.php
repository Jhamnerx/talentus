<?php

namespace App\View\Components\admin\settings;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PermisoInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $label, public $name, public $value, public $model)
    {
        //

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.settings.permiso-input');
    }
}

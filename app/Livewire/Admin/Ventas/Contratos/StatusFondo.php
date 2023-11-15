<?php

namespace App\Livewire\Admin\Ventas\Contratos;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class StatusFondo extends Component
{

    public Model $model;

    public $field;

    public $fondo;

    public function mount()
    {
        $this->fondo = (bool) $this->model->getAttribute($this->field);
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();
    }
    public function render()
    {
        return view('livewire.admin.ventas.contratos.status-fondo');
    }
}

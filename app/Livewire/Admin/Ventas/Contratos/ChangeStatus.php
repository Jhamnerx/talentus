<?php

namespace App\Livewire\Admin\Ventas\Contratos;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ChangeStatus extends Component
{
    public Model $model;

    public $field;

    public $estado;

    public function mount()
    {
        $this->estado = (bool) $this->model->getAttribute($this->field);
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();
    }

    public function render()
    {
        return view('livewire.admin.ventas.contratos.change-status');
    }
}

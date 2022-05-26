<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class StatusSello extends Component
{
    public Model $model;

    public $field;

    public $sello;

    public function mount()
    {
        $this->sello = (bool) $this->model->getAttribute($this->field);
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();
    }

    public function render()
    {
        return view('livewire.admin.ventas.contratos.status-sello');
    }
}

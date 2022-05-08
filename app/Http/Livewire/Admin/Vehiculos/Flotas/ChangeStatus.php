<?php

namespace App\Http\Livewire\Admin\Vehiculos\Flotas;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ChangeStatus extends Component
{
    public Model $model;

    public $field;

    public $is_active;

    public function mount()
    {
        $this->is_active = (bool) $this->model->getAttribute($this->field);
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();
    }
    public function render()
    {
        return view('livewire.admin.vehiculos.flotas.change-status');
    }
}

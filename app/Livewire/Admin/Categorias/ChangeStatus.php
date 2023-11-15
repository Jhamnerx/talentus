<?php

namespace App\Livewire\Admin\Categorias;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

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
        return view('livewire.admin.categorias.change-status');
    }
}

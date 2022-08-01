<?php

namespace App\Http\Livewire\Admin\Usuarios;

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
        $this->dispatchBrowserEvent('change-status', ['status' => $value]);
    }
    public function render()
    {
        return view('livewire.admin.usuarios.change-status');
    }
}

<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{
    public Model $model;


    public $field = "eliminado";

    public $eliminado;

    public function delete()
    {
        $this->model->setAttribute($this->field, '1')->save();
        // return redirect()->route('admin.vehiculos.index');
        $this->dispatchBrowserEvent('vehiculo-delete', ['delete' => $this->model]);

        $this->emit('updateTable');
    }
    public function render()
    {
        return view('livewire.admin.vehiculos.delete');
    }
}

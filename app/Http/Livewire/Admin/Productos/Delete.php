<?php

namespace App\Http\Livewire\Admin\Productos;

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
        return redirect()->route('admin.almacen.productos.index')->with('delete', 'El producto fue eliminado');;
    }
    public function render()
    {
        return view('livewire.admin.productos.delete');
    }
}

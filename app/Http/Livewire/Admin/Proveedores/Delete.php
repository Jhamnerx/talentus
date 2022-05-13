<?php

namespace App\Http\Livewire\Admin\Proveedores;

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
        return redirect()->route('admin.clientes.index')->with('delete', 'El El proveedor se elimino con exito');
    }
    public function render()
    {
        return view('livewire.admin.proveedores.delete');
    }
}

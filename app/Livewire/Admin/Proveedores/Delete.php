<?php

namespace App\Livewire\Admin\Proveedores;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{
    public Model $model;


    public $field = "eliminado";

    public $eliminado;

    public function delete()
    {
        $this->model->delete();
        return redirect()->route('admin.proveedores.index')->with('delete', 'El proveedor se elimino con exito');
    }
    public function render()
    {
        return view('livewire.admin.proveedores.delete');
    }
}

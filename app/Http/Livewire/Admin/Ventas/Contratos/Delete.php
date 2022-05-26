<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

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
        $this->dispatchBrowserEvent('contrato-delete', ['delete' => $this->model]);

        $this->emit('updateTable');
        //return redirect()->route('admin.clientes.index')->with('delete', 'El cliente se elimino con exito');;
    }
    public function render()
    {
        return view('livewire.admin.ventas.contratos.delete');
    }
}

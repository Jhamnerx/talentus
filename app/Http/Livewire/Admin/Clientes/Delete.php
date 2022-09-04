<?php

namespace App\Http\Livewire\Admin\Clientes;

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
        return redirect()->route('admin.clientes.index')->with('delete', 'El cliente se elimino con exito');
        $this->dispatchBrowserEvent('clientes-delete', ['delete' => $this->model]);

        $this->emit('updateTable');
    }
    public function render()
    {
        return view('livewire.admin.clientes.delete');
    }
}

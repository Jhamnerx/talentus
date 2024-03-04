<?php

namespace App\Livewire\Admin\Clientes\Contactos;

use App\Models\Contactos;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{

    public Contactos $contacto;


    public $field = "eliminado";

    public $eliminado;

    public function delete()
    {
        $this->contacto->delete();
        return redirect()->route('admin.clientes.contactos.index')->with('delete', 'El contacto se elimino con exito');;
    }

    public function render()
    {
        return view('livewire.admin.clientes.contactos.delete');
    }
}

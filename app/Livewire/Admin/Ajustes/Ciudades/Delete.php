<?php

namespace App\Livewire\Admin\Ajustes\Ciudades;

use App\Models\Ciudades;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{
    public Model $ciudad;
    public $openModalDelete;
    protected $listeners = [
        'openModalDelete'
    ];

    public function delete()
    {
       // $this->model->setAttribute($this->field, '1')->save();
         
       $this->ciudad->delete();
        return redirect()->route('admin.ajustes.ciudades')->with('delete', 'La ciudad se elimino con exito');
    }
    public function openModalDelete(Ciudades $ciudad){
        $this->openModalDelete = true;
        $this->ciudad = $ciudad;
    }

    public function render()
    {
        return view('livewire.admin.ajustes.ciudades.delete');
    }
}

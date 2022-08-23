<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

use App\Models\Contratos;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{
    public Model $contrato;

    public $openModalDelete = false;
    
    protected $listeners = [
        'openModalDelete'
    ];


    public $field = "eliminado";

    public $eliminado;

    public function delete()
    {
        //$this->model->setAttribute($this->field, '1')->save();

        $this->contrato->delete();
        $this->dispatchBrowserEvent('contrato-delete', ['delete' => $this->contrato]);
        $this->emit('updateTable');
    }

    public function openModalDelete(Contratos $contrato){
        
        $this->openModalDelete = true;
        $this->contrato = $contrato;
    }

    public function render()
    {
        return view('livewire.admin.ventas.contratos.delete');
    }
}

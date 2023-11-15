<?php

namespace App\Livewire\Admin\Ajustes\Ciudades;

use App\Models\Ciudades;
use Livewire\Component;
use Livewire\WithPagination;
class Show extends Component
{

    use WithPagination;
    public $openModalSave = false;
    public $openModalEdit = false;
    public $openModalDelete = false;

    protected $listeners = [
        'render'
    ];

    public function render()
    {
        $ciudades = Ciudades::paginate(5);
        return view('livewire.admin.ajustes.ciudades.show', compact('ciudades'));
    }

    public function openModalSave(){
        $this->dispatch('openModalSave');
        $this->openModalSave = true;

    }


    public function openModalEdit(Ciudades $ciudad){

        $this->dispatch('openModalEdit', $ciudad);
        $this->openModalEdit = true;

    }    
    public function openModalDelete(Ciudades $ciudad){
     
        $this->dispatch('openModalDelete', $ciudad);
        $this->openModalDelete = true;

    }
}

<?php

namespace App\Http\Livewire\Admin\Ajustes\Ciudades;

use App\Models\Ciudades;
use Livewire\Component;

class Show extends Component
{

    public $openModalSave = false;
    public $openModalEdit = false;
    public $openModalDelete = false;

    protected $listeners = [
        'render'
    ];

    public function render()
    {
        $ciudades = Ciudades::all();
        return view('livewire.admin.ajustes.ciudades.show', compact('ciudades'));
    }

    public function openModalSave(){
        $this->emit('openModalSave');
        $this->openModalSave = true;

    }


    public function openModalEdit(Ciudades $ciudad){

        $this->emit('openModalEdit', $ciudad);
        $this->openModalEdit = true;

    }    
    public function openModalDelete(Ciudades $ciudad){
     
        $this->emit('openModalDelete', $ciudad);
        $this->openModalDelete = true;

    }
}

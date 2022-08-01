<?php

namespace App\Http\Livewire\Admin\Ajustes\Roles;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Contracts\Permission;

use Livewire\Component;

class Show extends Component
{
    public $search;
    public $openModalSave = false;
    public $openModalEdit = false;


    public function render()
    {

        $roles = Role::where('name', 'like', '%' . $this->search . '%')->paginate(5);
        return view('livewire.admin.ajustes.roles.show', compact('roles'));
    }

    
    public function openModalSave(){
        $this->emit('openModalSave');
        $this->openModalSave = true;

    }
    public function openModalEdit($id){
        $this->emit('openModalEdit', $id);
        $this->openModalEdit = true;
    }
}

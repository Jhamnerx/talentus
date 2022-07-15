<?php

namespace App\Http\Livewire\Admin\Ajustes\Roles;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Contracts\Permission;

use Livewire\Component;

class Show extends Component
{
    public $openModalSave = false;


    public function render()
    {
        $roles = Role::paginate(10);
        return view('livewire.admin.ajustes.roles.show', compact('roles'));
    }

    
    public function openModalSave(){
        $this->emit('openModalSave');
        $this->openModalSave = true;

    }
}

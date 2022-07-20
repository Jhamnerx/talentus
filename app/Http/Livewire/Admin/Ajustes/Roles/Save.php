<?php

namespace App\Http\Livewire\Admin\Ajustes\Roles;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;

class Save extends Component
{
    public $openModalSave = false;

    public $name;

    public $permission = [];

    protected $rules = [
        'name' => 'required|unique:roles',
        'permission' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Escribe el nombre de rol.',
        'name.unique' => 'El rol ya existe.',
        'permission.required' => 'Selecciona al menos 1 permiso.',
    ];

    protected $listeners = [
        'openModalSave' => 'openModal'
    ];
    
    public function render()
    {
        return view('livewire.admin.ajustes.roles.save');
    }
    public function openModal()
    {
        $this->openModalSave = true;
    }
    public function closeModal()
    {
        $this->openModalSave = false;
        $this->reset();
        $this->resetErrorBag();
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save(){

        $this->validate();

        $rol = Role::create(['name' => $this->name]);
        $rol->syncPermissions($this->permission);
        //return redirect()->route('admin.ajustes.roles');
    }

    public function checkAll(){

        $permisos = Permission::get();
        //dd($permisos);
        foreach ($permisos as $permiso) {


            array_push($this->permission, $permiso->name);

        }
       

    }
    public function uncheckAll(){
        $this->reset('permission');
    }


}

<?php

namespace App\Http\Livewire\Admin\Ajustes\Roles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;

use Livewire\Component;

class Edit extends Component
{

    public $openModalEdit = false;

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
        'openModalEdit' => 'openModal'
    ];

    public function openModal(Role $rol)
    {
       // dd($rol);
        $this->openModalEdit = true;
        $this->permission = $rol->permissions->pluck('name');
        $this->name = $rol->name;
        // $this->permission = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $rol->id)
        // ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
        // ->all();
    }

    public function closeModal()
    {
        $this->openModalEdit = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.admin.ajustes.roles.edit');
    }
}

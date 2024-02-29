<?php

namespace App\Livewire\Admin\Ajustes\Roles;

use App\Http\Requests\RolesRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


use Livewire\Component;

class Edit extends Component
{

    public $openModalEdit = false;

    public $name;
    public $rol;

    public $permission;

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
        $this->permission = $rol->permissions->pluck('name')->toArray();
        // array_push($this->permission, $rol->permissions->pluck('name'));
        $this->name = $rol->name;
        $this->rol = $rol;
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

    public function updated($label)
    {

        $rolRequest = new RolesRequest();
        $this->validateOnly($label, $rolRequest->rules($this->rol), $rolRequest->messages());
    }

    public function render()
    {
        return view('livewire.admin.ajustes.roles.edit');
    }

    public function update()
    {

        $rol = Role::find($this->rol->id);
        $rol->name = $this->name;
        $rol->save();

        $rol->syncPermissions($this->permission);
        return redirect()->route('admin.ajustes.roles')->with('update', 'rol actualizado satisfactoriamente');
    }

    public function checkAll()
    {

        $permisos = Permission::get();
        //dd($permisos);
        foreach ($permisos as $permiso) {


            if (array_search($permiso->name, $this->permission) === false) {

                array_push($this->permission, $permiso->name);
                //dd($permiso->name);

            }
        }
    }
    public function uncheckAll()
    {
        $this->permission = [];
    }

    public function checkCategory($categoria)
    {

        $permisos = Permission::get();
        //dd($permisos);
        foreach ($permisos as $permiso) {

            if (strpos($permiso->name, $categoria)) {


                //array_push($this->permission, $permiso->name);
                if ($this->permission !== NULL) {

                    $valor = array_search($permiso->name, $this->permission);

                    if (array_search($permiso->name, $this->permission) === false) {

                        array_push($this->permission, $permiso->name);
                        //dd($permiso->name);

                    }
                }
            }
        }
    }
}

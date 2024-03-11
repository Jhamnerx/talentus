<?php

namespace App\Livewire\Admin\Ajustes\Roles;

use App\Http\Controllers\Admin\UtilesController;
use App\Http\Requests\RolesRequest;
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

    public function updated($label)
    {
        $rolRequest = new RolesRequest();
        $this->validateOnly($label, $rolRequest->rules(), $rolRequest->messages());
    }

    public function save()
    {
        $rolRequest = new RolesRequest();
        $values = $this->validate($rolRequest->rules(), $rolRequest->messages());

        $rol = Role::create(['name' => $this->name]);
        $rol->syncPermissions($this->permission);
        return redirect()->route('admin.ajustes.roles')->with('store', 'rol creado satisfactoriamente');
    }

    public function checkAll()
    {

        $permisos = Permission::get();
        foreach ($permisos as $permiso) {

            if (array_search($permiso->name, $this->permission) === false) {

                array_push($this->permission, $permiso->name);
            }
        }
    }
    public function uncheckAll()
    {
        $this->reset('permission');
    }

    public function checkCategory($categoria)
    {
        $permisos = Permission::get();

        foreach ($permisos as $permiso) {
            if (strpos($permiso->name, $categoria)) {

                // $valor = array_search($permiso->name, $this->permission);

                if (array_search($permiso->name, $this->permission) === false) {
                    array_push($this->permission, $permiso->name);
                }
            }
        }
    }

    public function checkComprobantesPermisos()
    {
        $perms = [
            'ver-comprobantes',
            'comprobantes-emitir-factura',
            'comprobantes-emitir-boleta',
            'comprobantes-emitir-nota-venta',
            'comprobantes-emitir-nota-credito',
            'comprobantes-emitir-nota-debito',
            'comprobantes-descargar-pdf',
            'comprobantes-descargar-xml',
            'comprobantes-ver-nota-credito',
            'comprobantes-ver-nota-debito',
            'comprobantes-nota-credito-pdf',
            'comprobantes-nota-credito-xml',
            'comprobantes-nota-debito-pdf',
            'comprobantes-nota-debito-xml',
        ];

        foreach ($perms  as $perm) {
            array_push($this->permission, $perm);
        }
    }

    public function checkMantenimiento()
    {

        $perms = [
            'ver-mantenimientos-vehiculos',
            'crear-mantenimientos-vehiculos',
            'editar-mantenimientos-vehiculos',
            'eliminar-mantenimientos-vehiculos',
            'task-mantenimientos-vehiculos',
            'mark-mantenimientos-vehiculos',
            'exportar-mantenimientos-vehiculos',
        ];

        foreach ($perms  as $perm) {
            array_push($this->permission, $perm);
        }
    }
}

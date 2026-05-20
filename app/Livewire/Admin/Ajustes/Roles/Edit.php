<?php

namespace App\Livewire\Admin\Ajustes\Roles;

use App\Http\Requests\RolesRequest;
use Illuminate\Support\Facades\Route as LaravelRoute;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Livewire\Component;

class Edit extends Component
{

    public $openModalEdit = false;

    public $name;
    public $rol;
    public $route_redirect = null;

    public $permission;

    public array $rutasDisponibles = [];

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
        $this->name = $rol->name;
        $this->route_redirect = $rol->route_redirect;
        $this->rol = $rol;
        $this->rutasDisponibles = $this->getAdminRoutes();
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

    public function save()
    {

        $rol = Role::find($this->rol->id);
        $rol->name = $this->name;
        $rol->guard_name = 'web';
        $rol->route_redirect = $this->route_redirect ?: null;
        $rol->save();

        $permissions = Permission::whereIn('name', $this->permission)->get();
        $rol->syncPermissions($permissions);
        $this->dispatch(
            'notify',
            icon: 'success',
            title: 'Rol Actualizado',
            mensaje: 'Rol actualizado satisfactoriamente'
        );
        $this->closeModal();
        // return redirect()->route('admin.ajustes.roles')->with('update', 'rol actualizado satisfactoriamente');
    }

    public function checkAll()
    {
        $this->permission = Permission::pluck('name')->toArray();
    }

    public function uncheckAll()
    {
        $this->permission = [];
    }

    public function checkCategory(string $categoria)
    {
        $names = Permission::where('name', 'like', "%{$categoria}%")->pluck('name')->toArray();
        $this->permission = array_values(array_unique(array_merge($this->permission ?? [], $names)));
    }

    public function checkComprobantesPermisos(): void
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
        $this->permission = array_values(array_unique(array_merge($this->permission ?? [], $perms)));
    }

    public function checkMantenimiento(): void
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
        $this->permission = array_values(array_unique(array_merge($this->permission ?? [], $perms)));
    }

    private function getAdminRoutes(): array
    {
        $crudSuffixes = ['create', 'store', 'edit', 'update', 'destroy', 'show', 'delete', 'restore'];

        return collect(LaravelRoute::getRoutes()->getRoutesByName())
            ->keys()
            ->filter(function (string $name) use ($crudSuffixes) {
                if (! str_starts_with($name, 'admin.')) {
                    return false;
                }
                if (str_starts_with($name, 'admin.ajustes.')) {
                    return false;
                }
                $last = substr($name, strrpos($name, '.') + 1);
                return ! in_array($last, $crudSuffixes, true);
            })
            ->sort()
            ->values()
            ->toArray();
    }
}

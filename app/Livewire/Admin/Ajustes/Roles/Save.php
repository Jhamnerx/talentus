<?php

namespace App\Livewire\Admin\Ajustes\Roles;

use App\Http\Requests\RolesRequest;
use Illuminate\Support\Facades\Route as LaravelRoute;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;

class Save extends Component
{
    public $openModalSave = false;

    public $name;

    public $route_redirect = null;

    public $permission = [];

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
        'openModalSave' => 'openModal'
    ];

    public function render()
    {
        return view('livewire.admin.ajustes.roles.save');
    }

    public function openModal()
    {
        $this->openModalSave = true;
        $this->rutasDisponibles = $this->getAdminRoutes();
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

        $rol = Role::create([
            'name'           => $this->name,
            'guard_name'     => 'web',
            'route_redirect' => $this->route_redirect ?: null,
        ]);
        $permissions = Permission::whereIn('name', $this->permission)->get();
        $rol->syncPermissions($permissions);
        return redirect()->route('admin.ajustes.roles')->with('store', 'rol creado satisfactoriamente');
    }

    public function checkAll()
    {
        $this->permission = Permission::pluck('name')->toArray();
    }

    public function uncheckAll()
    {
        $this->reset('permission');
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

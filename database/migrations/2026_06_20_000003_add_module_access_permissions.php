<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Permisos de acceso para módulos que no tenían ninguno (estaban abiertos o solo
 * protegidos por @role('admin'), que no es asignable granularmente). Permite
 * ocultar/mostrar cada módulo en el menú por permiso y asignarlo a cualquier rol.
 */
return new class extends Migration
{
    private array $permissions = [
        // Ajustes
        'admin.settings.firebase.index',
        'admin.settings.sla.index',
        'admin.settings.postventa.index',
        'admin.settings.operadores.index',
        'admin.settings.sectores.index',
        'admin.settings.rubros.index',
        'admin.settings.sunat.index',
        'admin.settings.bancos.index',
        'admin.settings.cuentas-bancarias.index',
        // Otros módulos
        'admin.planes.index',
        'admin.guias.drivers.index',
        'admin.guias.transports.index',
        'admin.guias.dispatchers.index',
        'admin.reviews.index',
    ];

    public function up(): void
    {
        foreach ($this->permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // El rol admin conserva acceso a lo que antes veía vía @role('admin').
        $admin = Role::where('name', 'admin')->where('guard_name', 'web')->first();
        if ($admin) {
            $admin->givePermissionTo(
                Permission::whereIn('name', $this->permissions)->get()
            );
        }
    }

    public function down(): void
    {
        Permission::whereIn('name', $this->permissions)
            ->where('guard_name', 'web')
            ->delete();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
};

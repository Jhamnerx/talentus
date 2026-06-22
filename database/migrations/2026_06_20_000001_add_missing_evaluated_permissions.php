<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Permisos que el código ya evalúa (en vistas/controladores para mostrar u
 * ocultar acciones) pero que no existían en la tabla `permissions`, por lo que
 * no se podían asignar a ningún rol desde el módulo de roles.
 */
return new class extends Migration
{
    private array $permissions = [
        'admin.settings.series.index',
        'admin.settings.plantilla.correo-config.edit',
        'editar-payment-methods',
        'ver-vehiculos-historial-mantenimientos',
        'eliminar-vehiculos-historial-mantenimientos',
        'crear-ordenes-trabajo',
    ];

    public function up(): void
    {
        foreach ($this->permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

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

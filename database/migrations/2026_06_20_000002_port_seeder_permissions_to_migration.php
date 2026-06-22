<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Estos permisos solo se creaban vía seeders (WhatsappPermissionsSeeder,
 * WhatsappRolesPermissionsSeeder, PortalAccesosPermissionsSeeder), que no se
 * ejecutan en cada despliegue. Se portan a migración (idempotente) para que
 * existan en todos los entornos tras `php artisan migrate`.
 *
 * Nota: los permisos de Finanzas realmente evaluados (ver-finanzas-*) ya fueron
 * portados en 2026_05_11_100000_add_missing_module_permissions. El
 * FinanzasPermissionsSeeder crea nombres legacy (ver-caja-chica, ...) que no se
 * evalúan en el código, por lo que no se portan aquí.
 */
return new class extends Migration
{
    private array $permissions = [
        // WhatsApp (roles de inbox: agente / supervisor / gerente)
        'ver-whatsapp',
        'ver-whatsapp-area',
        'ver-whatsapp-todos',
        // Portal de clientes
        'gestionar-accesos-portal',
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

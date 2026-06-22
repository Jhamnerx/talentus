<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Permiso para "Ingresar como" (impersonar usuarios) desde el módulo de usuarios.
 */
return new class extends Migration
{
    private string $permission = 'admin.usuarios.impersonate';

    public function up(): void
    {
        Permission::firstOrCreate(['name' => $this->permission, 'guard_name' => 'web']);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $admin = Role::where('name', 'admin')->where('guard_name', 'web')->first();
        if ($admin) {
            $admin->givePermissionTo($this->permission);
        }
    }

    public function down(): void
    {
        Permission::where('name', $this->permission)
            ->where('guard_name', 'web')
            ->delete();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
};

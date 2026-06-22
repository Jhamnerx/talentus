<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PortalAccesosPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = Permission::firstOrCreate([
            'name' => 'gestionar-accesos-portal',
            'guard_name' => 'web',
        ]);

        $adminRole = Role::where('name', 'Admin')->first();

        if ($adminRole) {
            $adminRole->givePermissionTo($permission);
        }

        $this->command->info('Permiso gestionar-accesos-portal creado exitosamente.');
    }
}

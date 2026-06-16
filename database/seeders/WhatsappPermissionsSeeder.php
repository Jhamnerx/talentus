<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class WhatsappPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permission = Permission::firstOrCreate([
            'name' => 'ver-whatsapp',
            'guard_name' => 'web',
        ]);

        $adminRole = Role::where('name', 'Admin')->first();

        if ($adminRole) {
            $adminRole->givePermissionTo($permission);
        }

        $this->command->info('Permiso ver-whatsapp creado exitosamente.');
    }
}

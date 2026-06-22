<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class WhatsappRolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'ver-whatsapp',       // Agente: SP#1 ya lo creó — firstOrCreate lo tolera
            'ver-whatsapp-area',  // Supervisor
            'ver-whatsapp-todos', // Gerente
        ];

        $createdPermissions = [];
        foreach ($permissions as $name) {
            $createdPermissions[] = Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($createdPermissions);
        }
    }
}

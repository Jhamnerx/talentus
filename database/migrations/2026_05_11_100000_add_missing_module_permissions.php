<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    private array $permissions = [
        // Work Orders
        'ver-work_order',
        'crear-work_order',
        'editar-work_order',
        'acciones-work_order',
        'cancelar-work_order',
        'descargar-work_order',
        'exportar-work_order',
        'admin-work_order',
        'tipos-work_order',
        // Tickets
        'ver-ticket',
        'crear-ticket',
        'editar-ticket',
        'asignar-ticket',
        'cambiar.estado-ticket',
        'eliminar-ticket',
        // WhatsApp / WhatsFleep
        'ver-dispositivos-wa',
        'gestionar-dispositivos-wa',
        'ver-contactos-wa',
        'gestionar-contactos-wa',
        'ver-campanias-wa',
        'gestionar-campanias-wa',
        'enviar-mensajes-wa',
        'ver-historial-wa',
        'gestionar-autoreplies-wa',
        // Finanzas
        'ver-finanzas-caja',
        'gestionar-finanzas-caja',
        'ver-finanzas-movimientos',
        'ver-finanzas-transacciones',
        'ver-finanzas-cuentas-cobrar',
        'gestionar-finanzas-cuentas-cobrar',
        'ver-finanzas-cuentas-pagar',
        'ver-finanzas-balance',
    ];

    public function up(): void
    {
        foreach ($this->permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // Asignar todos los permisos nuevos al rol admin
        $admin = \Spatie\Permission\Models\Role::where('name', 'admin')->first();
        if ($admin) {
            $admin->givePermissionTo($this->permissions);
        }
    }

    public function down(): void
    {
        foreach ($this->permissions as $name) {
            Permission::where('name', $name)->where('guard_name', 'web')->delete();
        }
    }
};

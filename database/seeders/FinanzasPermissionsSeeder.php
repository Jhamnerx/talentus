<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FinanzasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permisos para Caja Chica
        $cajaPermissions = [
            'ver-caja-chica',
            'crear-caja-chica',
            'editar-caja-chica',
            'eliminar-caja-chica',
        ];

        // Permisos para Movimientos
        $movimientosPermissions = [
            'ver-movimientos',
            'crear-movimientos',
            'editar-movimientos',
            'eliminar-movimientos',
        ];

        // Permisos para Transacciones
        $transaccionesPermissions = [
            'ver-transacciones',
            'exportar-transacciones',
        ];

        // Permisos para Ingresos
        $ingresosPermissions = [
            'ver-ingresos',
            'crear-ingresos',
            'editar-ingresos',
            'eliminar-ingresos',
        ];

        // Permisos para Cuentas por Cobrar
        $cuentasCobrarPermissions = [
            'ver-cuentas-cobrar',
            'crear-cuentas-cobrar',
            'editar-cuentas-cobrar',
            'eliminar-cuentas-cobrar',
            'registrar-pago-cobrar',
        ];

        // Permisos para Cuentas por Pagar
        $cuentasPagarPermissions = [
            'ver-cuentas-pagar',
            'crear-cuentas-pagar',
            'editar-cuentas-pagar',
            'eliminar-cuentas-pagar',
            'registrar-pago-pagar',
        ];

        // Permisos para Pagos
        $pagosPermissions = [
            'ver-pagos',
            'crear-pagos',
            'editar-pagos',
            'eliminar-pagos',
        ];

        // Permisos para Balance
        $balancePermissions = [
            'ver-balance',
            'exportar-balance',
        ];

        // Combinar todos los permisos
        $allPermissions = array_merge(
            $cajaPermissions,
            $movimientosPermissions,
            $transaccionesPermissions,
            $ingresosPermissions,
            $cuentasCobrarPermissions,
            $cuentasPagarPermissions,
            $pagosPermissions,
            $balancePermissions
        );

        // Crear permisos
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Asignar permisos al rol Admin (si existe)
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($allPermissions);
        }

        // Asignar permisos básicos al rol Finanzas (si existe)
        $finanzasRole = Role::where('name', 'Finanzas')->first();
        if ($finanzasRole) {
            $finanzasRole->givePermissionTo([
                'ver-caja-chica',
                'crear-caja-chica',
                'editar-caja-chica',
                'ver-movimientos',
                'crear-movimientos',
                'editar-movimientos',
                'ver-transacciones',
                'exportar-transacciones',
                'ver-ingresos',
                'crear-ingresos',
                'editar-ingresos',
                'ver-cuentas-cobrar',
                'registrar-pago-cobrar',
                'ver-cuentas-pagar',
                'registrar-pago-pagar',
                'ver-pagos',
                'ver-balance',
            ]);
        }

        $this->command->info('Permisos de Finanzas creados exitosamente.');
    }
}

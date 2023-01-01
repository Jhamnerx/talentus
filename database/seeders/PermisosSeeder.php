<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//Spatie
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'cliente']);
        $admin = Role::create(['name' => 'admin']);
        $monitoreo = Role::create(['name' => 'monitoreo']);
        $tecnico = Role::create(['name' => 'tecnico']);

        $permisos = [
            'admin.home',
            'cliente.home',
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'eliminar-rol',

            'ver-categoria',
            'crear-categoria',
            'editar-categoria',
            'eliminar-categoria',

            'ver-producto',
            'crear-producto',
            'editar-producto',
            'eliminar-producto',

            'ver-sim_card',
            'crear-sim_card',
            'editar-sim_card',
            'eliminar-sim_card',
            'importar-sim_card',
            'exportar-sim_card',



            'ver-dispositivo',
            'crear-dispositivo',
            'editar-dispositivo',
            'eliminar-dispositivo',
            'importar-dispositivo',
            'exportar-dispositivo',

            'ver-guias',
            'crear-guias',
            'editar-guias',
            'eliminar-guias',

            'ver-cliente',
            'crear-cliente',
            'editar-cliente',
            'eliminar-cliente',
            'exportar-cliente',
            'importar-cliente',

            'ver-contacto',
            'crear-contacto',
            'editar-contacto',
            'eliminar-contacto',

            'ver-proveedor',
            'crear-proveedor',
            'editar-proveedor',
            'eliminar-proveedor',
            'exportar-proveedor',
            'importar-proveedor',


            'ver-compras_facturas',
            'crear-compras_facturas',
            'editar-compras_facturas',
            'eliminar-compras_facturas',

            'ver-cotizaciones',
            'crear-cotizaciones',
            'editar-cotizaciones',
            'eliminar-cotizaciones',
            'convertir-cotizaciones',
            'enviar-cotizaciones',
            'estados-cotizaciones',

            'ver-ventas-facturas',
            'crear-ventas-facturas',
            'editar-ventas-facturas',
            'eliminar-ventas-facturas',
            'enviar-ventas-facturas',
            'estados-ventas-facturas',
            'exportar-ventas-facturas',

            'ver-recibos',
            'crear-recibos',
            'editar-recibos',
            'eliminar-recibos',
            'enviar-recibos',
            'exportar-recibos',


            'ver-contrato',
            'crear-contrato',
            'editar-contrato',
            'descargar-contrato',
            'enviar-contrato',
            'eliminar-contrato',

            'ver-vehiculos-flotas',
            'crear-vehiculos-flotas',
            'editar-vehiculos-flotas',
            'eliminar-vehiculos-flotas',


            'ver-vehiculos-vehiculos',
            'crear-vehiculos-vehiculos',
            'editar-vehiculos-vehiculos',
            'eliminar-vehiculos-vehiculos',

            'ver-vehiculos-reportes',
            'crear-vehiculos-reportes',
            'editar-vehiculos-reportes',
            'eliminar-vehiculos-reportes',

            'ver-certificados-actas',
            'crear-certificados-actas',
            'editar-certificados-actas',
            'descargar-certificados-actas',
            'enviar-certificados-actas',
            'eliminar-certificados-actas',

            'ver-certificados-gps',
            'crear-certificados-gps',
            'editar-certificados-gps',
            'descargar-certificados-gps',
            'enviar-certificados-gps',
            'eliminar-certificados-gps',

            'ver-certificados-velocimetros',
            'crear-certificados-velocimetros',
            'editar-certificados-velocimetros',
            'descargar-certificados-velocimetros',
            'enviar-certificados-velocimetros',
            'eliminar-certificados-velocimetros',


            'admin.solicitudes.index',
            'admin.solicitudes.finalize',

            'admin.reportes.index',
            'admin.reportes.logs.index',
            'admin.reportes.logs.actions',

            'admin.usuarios.index',
            'admin.usuarios.create',
            'admin.usuarios.edit',
            'admin.usuarios.delete',

            'admin.cobros.index',
            'admin.cobros.create',
            'admin.cobros.edit',
            'admin.cobros.delete',

            'admin.payments.index',
            'admin.payments.create',

            'admin.settings.ciudades.index',
            'admin.settings.ciudades.create',
            'admin.settings.ciudades.edit',
            'admin.settings.ciudades.delete',

            'admin.settings.roles.index',
            'admin.settings.roles.create',
            'admin.settings.roles.edit',
            'admin.settings.roles.delete',

            'admin.settings.plantilla.index',
            'admin.settings.plantilla.informacion.edit',
            'admin.settings.plantilla.sunat.edit',
            'admin.settings.plantilla.series.edit',
            'admin.settings.plantilla.images.edit',


            'tecnico.tareas.reportes',
            'tecnico.tareas.index',
            'tecnico.tareas.cards',
            'tecnico.tareas.cards.sin-leer',
            'tecnico.tareas.cards.complete.actions',
            'tecnico.tareas.cards.pendient.actions',
            'tecnico.tareas.cards.canceled.actions',
            'tecnico.tareas.tecnicos.admin',
            'tecnico.tareas.tabla-historial',
            'tecnico.tareas.create',
            'tecnico.tareas.edit',
            'tecnico.tareas.delete',
            'tecnico.tareas.action.pdf',
            'tecnico.tareas.action.wsp',

            'tecnico.tareas.tipo.index',
            'tecnico.tareas.tipo.create',
            'tecnico.tareas.tipo.edit',
            'tecnico.tareas.tipo.delete',

        ];


        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
        $role->givePermissionTo('cliente.home');
        $admin->givePermissionTo('admin.home');
        $monitoreo->givePermissionTo('ver-vehiculos-vehiculos');
        $tecnico->givePermissionTo('ver-vehiculos-vehiculos');
    }
}

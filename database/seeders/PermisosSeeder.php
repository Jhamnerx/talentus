<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//Spatie
use Spatie\Permission\Models\Permission;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [

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

            'ver-recibo',
            'crear-recibo',
            'editar-recibo',
            'eliminar-recibo',


            'ver-contrato',
            'crear-contrato',
            'editar-contrato',
            'descargar-contrato',
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
            'eliminar-certificados-actas',

            'ver-certificados-gps',
            'crear-certificados-gps',
            'editar-certificados-gps',
            'descargar-certificados-gps',
            'eliminar-certificados-gps',

            'ver-certificados-velocimetros',
            'crear-certificados-velocimetros',
            'editar-certificados-velocimetros',
            'descargar-certificados-velocimetros',
            'eliminar-certificados-velocimetros',


            
        ];

        foreach($permisos as $permiso){
            Permission::create(['name' => $permiso]);
        }

    }
}

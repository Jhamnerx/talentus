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
            'borrar-rol',

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
            'borrar-dispositivo',
            'importar-dispositivo',
            'exportar-dispositivo',

            'ver-guias',
            'crear-guias',
            'editar-guias',
            'borrar-guias',

            'ver-clientes',
            'crear-clientes',
            'editar-clientes',
            'borrar-clientes',


            'ver-proveedores',
            'crear-proveedores',
            'editar-proveedores',
            'borrar-proveedores',


            'ver-compras_facturas',
            'crear-compras_facturas',
            'editar-compras_facturas',
            'borrar-compras_facturas',

            'ver-ventas-cotizaciones',
            'crear-ventas-cotizaciones',
            'editar-ventas-cotizaciones',
            'borrar-ventas-cotizaciones',

            'ver-ventas-facturas',
            'crear-ventas-facturas',
            'editar-ventas-facturas',
            'borrar-ventas-facturas',

            'ver-ventas-recibos',
            'crear-ventas-recibos',
            'editar-ventas-recibos',
            'borrar-ventas-recibos',


            'ver-ventas-contratos',
            'crear-ventas-contratos',
            'editar-ventas-contratos',
            'borrar-ventas-contratos',

            'ver-vehiculos-flotas',
            'crear-vehiculos-flotas',
            'editar-vehiculos-flotas',
            'borrar-vehiculos-flotas',


            'ver-vehiculos-contactos',
            'crear-vehiculos-contactos',
            'editar-vehiculos-contactos',
            'borrar-vehiculos-contactos',

            'ver-vehiculos-vehiculos',
            'crear-vehiculos-vehiculos',
            'editar-vehiculos-vehiculos',
            'borrar-vehiculos-vehiculos',

            'ver-vehiculos-reportes',
            'crear-vehiculos-reportes',
            'editar-vehiculos-reportes',
            'borrar-vehiculos-reportes',

            'ver-certificados-actas',
            'crear-certificados-actas',
            'editar-certificados-actas',
            'borrar-certificados-actas',

            'ver-certificados-gps',
            'crear-certificados-gps',
            'editar-certificados-gps',
            'borrar-certificados-gps',

            'ver-certificados-velocimetros',
            'crear-certificados-velocimetros',
            'editar-certificados-velocimetros',
            'borrar-certificados-velocimetros',


            
        ];

        foreach($permisos as $permiso){
            Permission::create(['name' => $permiso]);
        }

    }
}

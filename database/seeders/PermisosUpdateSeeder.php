<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermisosUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            //VEHICULOS
            'exportar.vehiculos-vehiculos',
            'importar-vehiculos-vehiculos',

            'show-vehiculos-vehiculos',
            'ver-mantenimientos-vehiculos',
            'crear-mantenimientos-vehiculos',
            'editar-mantenimientos-vehiculos',
            'eliminar-mantenimientos-vehiculos',
            'task-mantenimientos-vehiculos',
            'mark-mantenimientos-vehiculos',
            'exportar-mantenimientos-vehiculos',


            //COMPROBANTES
            'ver-comprobantes',
            'comprobantes-emitir-factura',
            'comprobantes-emitir-boleta',
            'comprobantes-emitir-nota-venta',
            'comprobantes-emitir-nota-credito',
            'comprobantes-emitir-nota-debito',
            'comprobantes-descargar-pdf',
            'comprobantes-descargar-xml',
            'comprobantes-ver-nota-credito',
            'comprobantes-ver-nota-debito',
            'comprobantes-nota-credito-pdf',
            'comprobantes-nota-credito-xml',
            'comprobantes-nota-debito-pdf',
            'comprobantes-nota-debito-xml',

            'convertir-recibos',
        ];

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}

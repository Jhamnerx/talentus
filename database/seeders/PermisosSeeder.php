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

            'ver-categorias',
            'crear-categorias',
            'editar-categorias',
            'borrar-categorias',

        ];

        foreach($permisos as $permiso){
            Permission::create(['name' => $permiso]);
        }

    }
}

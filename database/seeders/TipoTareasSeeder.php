<?php

namespace Database\Seeders;

use App\Models\tipoTareas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoTareasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tareas = [
            [
                'nombre' => 'INSTALACIÓN',
                'costo' => '30',
            ], [
                'nombre' => 'CAMBIO DE CHIP',
                'costo' => '15',
            ], [
                'nombre' => 'DESINSTALACION',
                'costo' => '20',
            ],
            [
                'nombre' => 'INSTALACIÓN VELOCIMETRO',
                'costo' => '50',
            ], [
                'nombre' => 'MANTENIMIENTO GPS',
                'costo' => '15',
            ]
        ];

        foreach ($tareas as $tarea) {
            tipoTareas::create($tarea);
        }
    }
}

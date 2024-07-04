<?php

namespace Database\Seeders;

use App\Models\Sustentos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SustentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sustentos = [
            // [
            //     'codigo' => '01',
            //     'tipo' => 'C',
            //     'descripcion' => 'Anulación de la operación'
            // ],
            // [
            //     'codigo' => '02',
            //     'tipo' => 'C',
            //     'descripcion' => 'Anulación por error en el RUC'
            // ],
            // [
            //     'codigo' => '03',
            //     'tipo' => 'C',
            //     'descripcion' => 'Corrección por error en la descripción'
            // ],
            // [
            //     'codigo' => '04',
            //     'tipo' => 'C',
            //     'descripcion' => 'Descuento global'
            // ],
            // [
            //     'codigo' => '05',
            //     'tipo' => 'C',
            //     'descripcion' => 'Descuento por ítem'
            // ],
            // [
            //     'codigo' => '06',
            //     'tipo' => 'C',
            //     'descripcion' => 'Devolución total'
            // ],
            // [
            //     'codigo' => '07',
            //     'tipo' => 'C',
            //     'descripcion' => 'Devolución por ítem'
            // ],
            // [
            //     'codigo' => '08',
            //     'tipo' => 'C',
            //     'descripcion' => 'Bonificación'
            // ],
            // [
            //     'codigo' => '09',
            //     'tipo' => 'C',
            //     'descripcion' => 'Disminución en el valor'
            // ],
            // [
            //     'codigo' => '10',
            //     'tipo' => 'C',
            //     'descripcion' => 'Otros Conceptos'
            // ],
            // [
            //     'codigo' => '11',
            //     'tipo' => 'C',
            //     'descripcion' => 'Ajustes de operaciones de exportación'
            // ],
            // [
            //     'codigo' => '12',
            //     'tipo' => 'C',
            //     'descripcion' => 'Ajustes afectos al IVAP'
            // ],
            // [
            //     'codigo' => '01',
            //     'tipo' => 'D',
            //     'descripcion' => 'Intereses por mora'
            // ],
            // [
            //     'codigo' => '02',
            //     'tipo' => 'D',
            //     'descripcion' => 'Aumento en el valor'
            // ],
            // [
            //     'codigo' => '03',
            //     'tipo' => 'D',
            //     'descripcion' => 'Penalidades/ otros conceptos'
            // ],
            // [
            //     'codigo' => '10',
            //     'tipo' => 'D',
            //     'descripcion' => 'Ajustes de operaciones de exportación'
            // ],
            [
                'codigo' => '13',
                'tipo' => 'C',
                'descripcion' => 'Ajustes - montos y/o fechas de pago'
            ]
        ];

        foreach ($sustentos as $sustento) {

            Sustentos::create($sustento);
        }
    }
}

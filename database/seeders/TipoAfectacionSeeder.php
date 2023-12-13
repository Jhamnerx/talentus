<?php

namespace Database\Seeders;

use App\Models\TipoAfectacion;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TipoAfectacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [

            [
                'codigo' => '10',
                'descripcion' => 'Gravado - Operación Onerosa',
                'codigo_afectacion' => '1000',
                'nombre_afectacion' => 'IGV',
                'tipo_afectacion' => 'VAT',
                'letra' => 'S'
            ],
            [
                'codigo' => '11',
                'descripcion' => 'Gravado – Retiro por premio',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'GRA',
                'tipo_afectacion' => 'FRE',
                'letra' => 'Z'
            ],
            [
                'codigo' => '12',
                'descripcion' => 'Gravado – Retiro por donación',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'GRA',
                'tipo_afectacion' => 'FRE',
                'letra' => 'Z'
            ],
            [
                'codigo' => '13',
                'descripcion' => 'Gravado – Retiro',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'GRA',
                'tipo_afectacion' =>
                'FRE',
                'letra' => 'Z'

            ],
            [
                'codigo' => '14',
                'descripcion' => 'Gravado – Retiro por publicidad',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'GRA',
                'tipo_afectacion' => 'FRE',
                'letra' => 'Z'
            ],
            [
                'codigo' => '15',
                'descripcion' => 'Gravado – Bonificaciones',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'GRA',
                'tipo_afectacion' => 'FRE',
                'letra' => 'Z'
            ],
            [
                'codigo' => '16',
                'descripcion' => 'Gravado – Retiro por entrega a trabajadores',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'GRA',
                'tipo_afectacion' => 'FRE',
                'letra' => 'Z'
            ],
            [
                'codigo' => '17',
                'descripcion' => 'Gravado - IVAP',
                'codigo_afectacion' => '1016',
                'nombre_afectacion' => 'IVAP',
                'tipo_afectacion' => 'VAT',
                'letra' => 'E'
            ],
            [
                'codigo' => '20',
                'descripcion' => 'Exonerado - Operación Onerosa',
                'codigo_afectacion' => '9997',
                'nombre_afectacion' => 'EXO',
                'tipo_afectacion' => 'VAT',
                'letra' => 'E'
            ],  [
                'codigo' => '21',
                'descripcion' => 'Exonerado - Transferencia gratuita',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'EXO',
                'tipo_afectacion' => 'VAT',
                'letra' => 'Z'
            ],  [
                'codigo' => '30',
                'descripcion' => 'Inafecto - Operación Onerosa',
                'codigo_afectacion' => '9998',
                'nombre_afectacion' => 'INA',
                'tipo_afectacion' => 'FRE',
                'letra' => 'O'
            ], [
                'codigo' => '31',
                'descripcion' => 'Inafecto – Retiro por Bonificación',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'GRA',
                'tipo_afectacion' => 'FRE',
                'letra' => 'Z'
            ],
            [
                'codigo' => '32',
                'descripcion' => 'Inafecto – Retiros',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'GRA',
                'tipo_afectacion' => 'FRE',
                'letra' => 'Z'
            ], [
                'codigo' => '33',
                'descripcion' => 'Inafecto – Retiro por Muestras Médicas',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'GRA',
                'tipo_afectacion' => 'FRE',
                'letra' => 'Z'
            ],
            [
                'codigo' => '34',
                'descripcion' => 'Inafecto - Retiro por Convenio Colectivo',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'GRA',
                'tipo_afectacion' => 'FRE',
                'letra' => 'Z'
            ],
            [
                'codigo' => '35',
                'descripcion' => 'Inafecto – Retiro por premio',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'GRA',
                'tipo_afectacion' => 'FRE',
                'letra' => 'Z'
            ],
            [
                'codigo' => '36',
                'descripcion' => 'Inafecto - Retiro por publicidad',
                'codigo_afectacion' => '9996',
                'nombre_afectacion' => 'GRA',
                'tipo_afectacion' => 'FRE',
                'letra' => 'Z'
            ],
            // [
            //     'codigo' => '40',
            //     'descripcion' => 'Exportación de Bienes o Servicios',
            //     'codigo_afectacion' => '9995',
            //     'nombre_afectacion' => 'EXP',
            //     'tipo_afectacion' => 'FRE',
            //     'letra' => 'G'
            // ],


        ];

        foreach ($tipos as $tipo) {

            TipoAfectacion::create($tipo);
        }
    }
}

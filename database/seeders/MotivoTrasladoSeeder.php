<?php

namespace Database\Seeders;

use App\Models\MotivoTraslado;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MotivoTrasladoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $motivos = [
            [
                'codigo' => '01',
                'descripcion' => 'VENTA',
            ],
            [
                'codigo' => '02',
                'descripcion' => 'COMPRA'
            ],
            [
                'codigo' => '04',
                'descripcion' => 'TRASLADO ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA'
            ],
            // [
            //     'codigo' => '08',
            //     'descripcion' => 'IMPORTACIÓN'
            // ],
            // [
            //     'codigo' => '09',
            //     'descripcion' => 'EXPORTACIÓN'
            // ],
            [
                'codigo' => '13',
                'descripcion' => 'OTROS'
            ],
            [
                'codigo' => '14',
                'descripcion' => 'VENTA SUJETA A CONFIRMACIÓN DEL COMPRADOR'
            ],
            [
                'codigo' => '18',
                'descripcion' => 'TRASLADO EMISOR ITINERANTE CP'
            ],

            [
                'codigo' => '19',
                'descripcion' => 'TRASLADO A ZONA PRIMARIA'
            ],

        ];

        foreach ($motivos as $motivo) {

            MotivoTraslado::create($motivo);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\MotivoTraslado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotivosTrasladoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $motivos = [

            [
                'codigo' => '01',
                'descripcion' => 'Venta',
            ],

            [
                'codigo' => '14',
                'descripcion' => 'Venta sujeta a confirmación del comprador'
            ],
            [
                'codigo' => '02',
                'descripcion' => 'Compra'
            ],
            [
                'codigo' => '04',
                'descripcion' => 'Traslado entre establecimientos de la misma empresa'
            ],
            // [
            //     'codigo' => '18',
            //     'descripcion' => 'Traslado emisor itinerante CP'
            // ],
            // [
            //     'codigo' => '08',
            //     'descripcion' => 'Importación'
            // ],
            // [
            //     'codigo' => '09',
            //     'descripcion' => 'Exportación'
            // ],
            // [
            //     'codigo' => '19',
            //     'descripcion' => 'Traslado a zona primaria'
            // ],
            [
                'codigo' => '13',
                'descripcion' => 'Otros'
            ],
        ];

        MotivoTraslado::create($motivos);
    }
}

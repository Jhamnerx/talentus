<?php

namespace Database\Seeders;

use App\Models\ModalidadTransporte;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModalidadTransporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transportes = [
            [
                'codigo' => '01',
                'descripcion' => 'TRANSPORTE PÚBLICO',
            ],
            [
                'codigo' => '02',
                'descripcion' => 'TRANSPORTE PRIVADO'
            ]
        ];

        foreach ($transportes as $transporte) {

            ModalidadTransporte::create($transporte);
        }
    }
}

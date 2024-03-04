<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class tipoDocumentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'codigo' => '0',
                'descripcion' => 'SIN DOCUMENTO',
            ],
            [
                'codigo' => '1',
                'descripcion' => 'D.N.I',
            ],
            [
                'codigo' => '4',
                'descripcion' => 'CARNET DE EXTRANJERÍA',
            ],
            [
                'codigo' => '6',
                'descripcion' => 'R.U.C.',
            ],
            [
                'codigo' => '7',
                'descripcion' => 'PASAPORTE',
            ],
            [
                'codigo' => 'A',
                'descripcion' => 'CÉDULA DIPLOMÁTICA DE IDENTIDAD',
            ],
            [
                'codigo' => 'B',
                'descripcion' => 'DOCUMENTO IDENTIDAD PAIS RESIDENCIA-NO.D',
            ],
            [
                'codigo' => 'C',
                'descripcion' => 'Tax Identification Number - TIN – Doc Trib PP.',
            ],
            [
                'codigo' => 'D',
                'descripcion' => 'Identification Number - IN – Doc Trib PP. JJ',
            ],
            [
                'codigo' => 'E',
                'descripcion' => 'TAM- Tarjeta Andina de Migración',
            ],

        ];

        foreach ($tipos as $tipo) {

            TipoDocumento::create($tipo);
        }
    }
}

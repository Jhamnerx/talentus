<?php

namespace Database\Seeders;

use App\Models\Series;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $series1 = [
            [
                'tipo_comprobante_id' => '00',
                'serie' => 'PRE',
                'correlativo' => '0',
                'empresa_id' => 1,
            ],
            [
                'tipo_comprobante_id' => '01',
                'serie' => 'F001',
                'correlativo' => '0',
                'empresa_id' => 1,
            ],
            [
                'tipo_comprobante_id' => '01',
                'serie' => 'F002',
                'correlativo' => '0',
                'empresa_id' => 1,
            ],
            [
                'tipo_comprobante_id' => '02',
                'serie' => 'BV01',
                'correlativo' => '0',
                'empresa_id' => 1,
            ],
            [
                'tipo_comprobante_id' => '03',
                'serie' => 'B001',
                'correlativo' => '0',
                'empresa_id' => 1,
            ],
            [
                'tipo_comprobante_id' => '07',
                'serie' => 'BN01',
                'correlativo' => '0',
                'empresa_id' => 1,
            ],
            [
                'tipo_comprobante_id' => '07',
                'serie' => 'FN01',
                'correlativo' => '0',
                'empresa_id' => 1,
            ],
            [
                'tipo_comprobante_id' => '08',
                'serie' => 'BD01',
                'correlativo' => '0',
                'empresa_id' => 1,
            ],
            [
                'tipo_comprobante_id' => '08',
                'serie' => 'FD01',
                'correlativo' => '0',
                'empresa_id' => 1,
            ],
            [
                'tipo_comprobante_id' => '09',
                'serie' => 'T001',
                'correlativo' => '0',
                'empresa_id' => 1,
            ],

            [
                'tipo_comprobante_id' => '10',
                'serie' => 'R001',
                'correlativo' => '0',
                'empresa_id' => 1,
            ],
            [
                'tipo_comprobante_id' => '11',
                'serie' => 'RG01',
                'correlativo' => '0',
                'empresa_id' => 1,
            ],
        ];
        $series2 = [
            [
                'tipo_comprobante_id' => '00',
                'serie' => 'PRE',
                'correlativo' => '0',
                'empresa_id' => 2,
            ],
            [
                'tipo_comprobante_id' => '01',
                'serie' => 'F001',
                'correlativo' => '0',
                'empresa_id' => 2,
            ],
            [
                'tipo_comprobante_id' => '01',
                'serie' => 'F002',
                'correlativo' => '0',
                'empresa_id' => 2,
            ],
            [
                'tipo_comprobante_id' => '02',
                'serie' => 'BV01',
                'correlativo' => '0',
                'empresa_id' => 2,
            ],
            [
                'tipo_comprobante_id' => '03',
                'serie' => 'B001',
                'correlativo' => '0',
                'empresa_id' => 2,
            ],
            [
                'tipo_comprobante_id' => '07',
                'serie' => 'BN01',
                'correlativo' => '0',
                'empresa_id' => 2,
            ],
            [
                'tipo_comprobante_id' => '07',
                'serie' => 'FN01',
                'correlativo' => '0',
                'empresa_id' => 2,
            ],
            [
                'tipo_comprobante_id' => '08',
                'serie' => 'BD01',
                'correlativo' => '0',
                'empresa_id' => 2,
            ],
            [
                'tipo_comprobante_id' => '08',
                'serie' => 'FD01',
                'correlativo' => '0',
                'empresa_id' => 2,
            ],
            [
                'tipo_comprobante_id' => '09',
                'serie' => 'T001',
                'correlativo' => '0',
                'empresa_id' => 2,
            ],
            [
                'tipo_comprobante_id' => '10',
                'serie' => 'R001',
                'correlativo' => '0',
                'empresa_id' => 2,
            ],
            [
                'tipo_comprobante_id' => '11',
                'serie' => 'RG01',
                'correlativo' => '0',
                'empresa_id' => 2,
            ],

        ];
        foreach ($series1 as $serie) {

            Series::create($serie);
        }
        foreach ($series2 as $serie) {

            Series::create($serie);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\TipoComprobantes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class tipoComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'codigo' => '00',
                'descripcion' => 'COTIZACIÓN',
                'slug' => 'cotizacion'
            ],
            [
                'codigo' => '01',
                'descripcion' => 'FACTURA',
                'slug' => 'factura'
            ],
            [
                'codigo' => '02',
                'descripcion' => 'NOTA DE VENTA',
                'slug' => 'nota-venta'
            ],
            [
                'codigo' => '03',
                'descripcion' => 'BOLETA',
                'slug' => 'boleta'
            ],
            [
                'codigo' => '07',
                'descripcion' => 'NOTA DE CRÉDITO',
                'slug' => 'nota-credito'
            ],
            [
                'codigo' => '08',
                'descripcion' => 'NOTA DE DEBITO',
                'slug' => 'nota-debito'
            ],
            [
                'codigo' => '09',
                'descripcion' => 'GUIA DE REMISION',
                'slug' => 'guia-remision'
            ],
            [
                'codigo' => 'RA',
                'descripcion' => 'RESUMEN ANULACIONES',
                'slug' => 'resumen-anulaciones'
            ],
            [
                'codigo' => 'RC',
                'descripcion' => 'RESUMEN COMPROBANTE',
                'slug' => 'resumen-comprabante'
            ]

        ];

        foreach ($tipos as $tipo) {

            TipoComprobantes::create($tipo);
        }
    }
}

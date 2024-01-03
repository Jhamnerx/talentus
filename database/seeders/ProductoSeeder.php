<?php

namespace Database\Seeders;

use App\Models\Imagen;
use App\Models\Clientes;
use App\Models\Categoria;
use App\Models\Productos;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // Categoria::create([
        //     'nombre' => 'EQUIPOS GPS',
        //     'descripcion' => 'Categoria para los dispositivos gps',
        //     'empresa_id' => '1',
        // ]);

        // Categoria::create([
        //     'nombre' => 'INSTALACIONES',
        //     'descripcion' => '',
        //     'empresa_id' => '1',
        // ]);

        // Categoria::create([
        //     'nombre' => 'MONITOREO SATELITAL',
        //     'descripcion' => '',
        //     'empresa_id' => '1',
        // ]);

        // $velocimetro = Categoria::create([
        //     'nombre' => 'VELOCIMETROS DIGITALES',
        //     'descripcion' => '',
        //     'empresa_id' => '1',
        // ]);

        // $productos = [[
        //     'codigo' => 'PROD-001',
        //     'nombre' => 'EQUIPO GPS FMB920',
        //     'stock' => '0',
        //     'precio' => '120',
        //     'divisa' => 'USD',
        //     'tipo' => 'producto',
        //     'categoria_id' => '1',
        //     'empresa_id' => '1',
        //     'unit_code' => 'NIU'
        // ], [
        //     'codigo' => 'PROD-002',
        //     'nombre' => 'EQUIPO GPS FMU130',
        //     'stock' => '0',
        //     'precio' => '120',
        //     'divisa' => 'USD',
        //     'tipo' => 'producto',
        //     'categoria_id' => '1',
        //     'empresa_id' => '1',
        //     'unit_code' => 'NIU'
        // ], [
        //     'codigo' => 'PROD-003',
        //     'nombre' => 'EQUIPO GPS FMC130',
        //     'stock' => '0',
        //     'precio' => '120',
        //     'divisa' => 'USD',
        //     'tipo' => 'producto',
        //     'categoria_id' => '1',
        //     'empresa_id' => '1',
        //     'unit_code' => 'NIU'
        // ], [
        //     'codigo' => 'PROD-004',
        //     'nombre' => 'INSTALACION EQUIPO GPS',
        //     'stock' => '0',
        //     'precio' => '45',
        //     'divisa' => 'PEN',
        //     'tipo' => 'servicio',
        //     'categoria_id' => '2',
        //     'empresa_id' => '1',
        //     'unit_code' => 'ZZ'
        // ], [
        //     'codigo' => 'PROD-005',
        //     'nombre' => 'CAMBIO DE SIM CARD',
        //     'stock' => '0',
        //     'precio' => '45',
        //     'divisa' => 'PEN',
        //     'tipo' => 'servicio',
        //     'categoria_id' => '2',
        //     'empresa_id' => '1',
        //     'unit_code' => 'ZZ'
        // ], [
        //     'codigo' => 'PROD-006',
        //     'nombre' => 'MANTENIMIENTO EQUIPO GPS',
        //     'stock' => '0',
        //     'precio' => '45',
        //     'divisa' => 'PEN',
        //     'tipo' => 'servicio',
        //     'categoria_id' => '2',
        //     'empresa_id' => '1',
        //     'unit_code' => 'ZZ'
        // ], [
        //     'codigo' => 'PROD-007',
        //     'nombre' => 'MONITOREO SATELITAL | PLATAFORMA PREMIUM',
        //     'stock' => '0',
        //     'precio' => '45',
        //     'tipo' => 'servicio',
        //     'divisa' => 'PEN',
        //     'categoria_id' => '3',
        //     'empresa_id' => '1',
        //     'unit_code' => 'ZZ'
        // ], [
        //     'codigo' => 'PROD-008',
        //     'nombre' => 'MONITOREO SATELITAL| PLATAFORMA BASICA',
        //     'stock' => '0',
        //     'precio' => '35',
        //     'divisa' => 'PEN',
        //     'tipo' => 'servicio',
        //     'categoria_id' => '3',
        //     'empresa_id' => '1',
        //     'unit_code' => 'ZZ'
        // ], [
        //     'codigo' => 'PROD-009',
        //     'nombre' => 'MONITOREO SATELITAL ANUAL| PLATAFORMA BASICA',
        //     'stock' => '0',
        //     'precio' => '420',
        //     'divisa' => 'PEN',
        //     'tipo' => 'servicio',
        //     'categoria_id' => '3',
        //     'empresa_id' => '1',
        //     'unit_code' => 'ZZ'
        // ], [
        //     'codigo' => 'PROD-010',
        //     'nombre' => 'MONITOREO SATELITAL ANUAL| PLATAFORMA PREMIUM',
        //     'stock' => '0',
        //     'precio' => '540',
        //     'divisa' => 'PEN',
        //     'tipo' => 'servicio',
        //     'categoria_id' => '3',
        //     'empresa_id' => '1',
        //     'unit_code' => 'ZZ'
        // ], [
        //     'codigo' => 'PROD-011',
        //     'nombre' => 'VELOCIMETRO VEL4D-G',
        //     'stock' => '0',
        //     'precio' => '540',
        //     'divisa' => 'PEN',
        //     'tipo' => 'producto',
        //     'categoria_id' => $velocimetro->id,
        //     'empresa_id' => '1',
        //     'unit_code' => 'NIU'
        // ], [
        //     'codigo' => 'PROD-011',
        //     'nombre' => 'VELOCIMETRO VEL3D-G',
        //     'stock' => '0',
        //     'precio' => '540',
        //     'divisa' => 'PEN',
        //     'tipo' => 'producto',
        //     'categoria_id' => $velocimetro->id,
        //     'empresa_id' => '1',
        //     'unit_code' => 'NIU'
        // ]];

        // foreach ($productos as $producto) {
        //     Productos::create($producto);
        // }

        $productos = [
            [
                'categoria_id' => 5,
                'codigo' => '9000',
                'serie' => '100',
                'descripcion' => 'CUADERNO',
                'stock' => 6,

                'valor_unitario' => 5.00,

                'ventas' => 0,

                'user_id' => 1,
                'unit_code' => 'NIU',
                'afecto_icbper' => 0,
                'empresa_id' => '1',
            ],
            [
                'categoria_id' => 5,
                'codigo' => '9001',
                'serie' => '101',
                'descripcion' => 'LIBRO NORMA',
                'stock' => 6,

                'valor_unitario' => 100.00,

                'ventas' => 0,

                'user_id' => 1,
                'unit_code' => 'NIU',
                'afecto_icbper' => 0,
                'empresa_id' => '1',
            ],
            [
                'categoria_id' => 5,
                'codigo' => '9002',
                'serie' => '102',
                'descripcion' => 'PLATANOS',
                'stock' => 6,

                'valor_unitario' => 1.00,

                'ventas' => 0,

                'user_id' => 1,
                'unit_code' => 'NIU',
                'afecto_icbper' => 0,
                'empresa_id' => '1',
            ],
            [
                'categoria_id' => 5,
                'codigo' => '9003',
                'serie' => '103',
                'descripcion' => 'BOLSA PLASTICA',
                'stock' => 60,

                'valor_unitario' => 0.17,

                'ventas' => 0,

                'user_id' => 1,
                'unit_code' => 'NIU',
                'afecto_icbper' => 1,
                'empresa_id' => '1',
            ],
            [
                'categoria_id' => 5,
                'codigo' => '101',
                'serie' => '104',
                'descripcion' => 'WORKSHOP OFFICE 2016',
                'stock' => 60,

                'valor_unitario' => 2754,

                'ventas' => 0,

                'user_id' => 1,
                'unit_code' => 'NIU',
                'afecto_icbper' => 0,
                'empresa_id' => '1',
            ],           [
                'categoria_id' => 5,
                'codigo' => '101',
                'serie' => '105',
                'descripcion' => 'MONITOREO SATELITAL',
                'stock' => 60,

                'valor_unitario' => 300,

                'ventas' => 0,

                'user_id' => 1,
                'unit_code' => 'NIU',
                'afecto_icbper' => 0,
                'empresa_id' => '1',
            ],
        ];


        foreach ($productos as $producto) {

            Productos::create($producto);
        }
    }
}

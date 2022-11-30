<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Imagen;
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


        Categoria::create([
            'nombre' => 'EQUIPOS GPS',
            'descripcion' => 'Categoria para los dispositivos gps',
            'empresa_id' => 1,
        ]);

        Categoria::create([
            'nombre' => 'INSTALACIONES',
            'descripcion' => '',
            'empresa_id' => 1,
        ]);

        Categoria::create([
            'nombre' => 'MONITOREO SATELITAL',
            'descripcion' => '',
            'empresa_id' => 1,
        ]);

        Categoria::create([
            'nombre' => 'VELOCIMETROS DIGITALES',
            'descripcion' => '',
            'empresa_id' => 1,
        ]);

        $productos = [[
            'codigo' => 'PROD-001',
            'nombre' => 'EQUIPO GPS FMB920',
            'stock' => '0',
            'precio' => '120',
            'divisa' => 'USD',
            'tipo' => 'producto',
            'categoria_id' => '1',
            'empresa_id' => '1',
            'unit_code' => 'NIU'
        ], [
            'codigo' => 'PROD-002',
            'nombre' => 'EQUIPO GPS FMU130',
            'stock' => '0',
            'precio' => '120',
            'divisa' => 'USD',
            'tipo' => 'producto',
            'categoria_id' => '1',
            'empresa_id' => '1',
            'unit_code' => 'NIU'
        ], [
            'codigo' => 'PROD-003',
            'nombre' => 'EQUIPO GPS FMC130',
            'stock' => '0',
            'precio' => '120',
            'divisa' => 'USD',
            'tipo' => 'producto',
            'categoria_id' => '1',
            'empresa_id' => '1',
            'unit_code' => 'NIU'
        ], [
            'codigo' => 'PROD-004',
            'nombre' => 'INSTALACION EQUIPO GPS',
            'stock' => '0',
            'precio' => '45',
            'divisa' => 'PEN',
            'tipo' => 'servicio',
            'categoria_id' => '2',
            'empresa_id' => '1',
            'unit_code' => 'ZZ'
        ], [
            'codigo' => 'PROD-005',
            'nombre' => 'CAMBIO DE SIM CARD',
            'stock' => '0',
            'precio' => '45',
            'divisa' => 'PEN',
            'tipo' => 'servicio',
            'categoria_id' => '2',
            'empresa_id' => '1',
            'unit_code' => 'ZZ'
        ], [
            'codigo' => 'PROD-006',
            'nombre' => 'MANTENIMIENTO EQUIPO GPS',
            'stock' => '0',
            'precio' => '45',
            'divisa' => 'PEN',
            'tipo' => 'servicio',
            'categoria_id' => '2',
            'empresa_id' => '1',
            'unit_code' => 'ZZ'
        ], [
            'codigo' => 'PROD-007',
            'nombre' => 'MONITOREO SATELITAL | PLATAFORMA PREMIUM',
            'stock' => '0',
            'precio' => '45',
            'tipo' => 'servicio',
            'divisa' => 'PEN',
            'categoria_id' => '3',
            'empresa_id' => '1',
            'unit_code' => 'ZZ'
        ], [
            'codigo' => 'PROD-008',
            'nombre' => 'MONITOREO SATELITAL| PLATAFORMA BASICA',
            'stock' => '0',
            'precio' => '35',
            'divisa' => 'PEN',
            'tipo' => 'servicio',
            'categoria_id' => '3',
            'empresa_id' => '1',
            'unit_code' => 'ZZ'
        ], [
            'codigo' => 'PROD-009',
            'nombre' => 'MONITOREO SATELITAL ANUAL| PLATAFORMA BASICA',
            'stock' => '0',
            'precio' => '420',
            'divisa' => 'PEN',
            'tipo' => 'servicio',
            'categoria_id' => '3',
            'empresa_id' => '1',
            'unit_code' => 'ZZ'
        ], [
            'codigo' => 'PROD-010',
            'nombre' => 'MONITOREO SATELITAL ANUAL| PLATAFORMA PREMIUM',
            'stock' => '0',
            'precio' => '540',
            'divisa' => 'PEN',
            'tipo' => 'servicio',
            'categoria_id' => '3',
            'empresa_id' => '1',
            'unit_code' => 'ZZ'
        ]];

        foreach ($productos as $producto) {
            Productos::create($producto);
        }
    }
}

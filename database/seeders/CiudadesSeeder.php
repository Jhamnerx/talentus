<?php

namespace Database\Seeders;

use App\Models\Ciudades;
use Illuminate\Database\Seeder;

class CiudadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ciudades::create([
            'nombre' => 'Cajamarca',
            'prefijo' => 'C'
        ]);
        Ciudades::create([
            'nombre' => 'Trujillo',
            'prefijo' => 'T'
        ]);
        Ciudades::create([
            'nombre' => 'Lima',
            'prefijo' => 'L'
        ]);
        Ciudades::create([
            'nombre' => 'Piura',
            'prefijo' => 'P'
        ]);
        Ciudades::create([
            'nombre' => 'Moquegua',
            'prefijo' => 'MQ'
        ]);
    }
}

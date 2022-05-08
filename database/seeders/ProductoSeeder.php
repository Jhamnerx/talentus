<?php

namespace Database\Seeders;

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
        $productos = Productos::factory(20)->create();

        foreach ($productos as $producto) {

            Imagen::factory(1)->create([
                'imageable_id' => $producto->id,
                'imageable_type' => Productos::class,
            ]);
        }
    }
}

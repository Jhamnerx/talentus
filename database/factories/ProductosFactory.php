<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $tipo = $this->faker->randomElement(['servicio', 'producto']);
        return [
            'codigo' => $this->faker->unique()->ean8(),
            'nombre' => $this->faker->word(12),
            'tipo' => $tipo,
            'precio' => '19.99',
            'stock' => $tipo == 'servicio' ? '0' : random_int(10, 500),
            'categoria_id' => Categoria::all()->random()->id,
            'empresa_id' => Empresa::all()->random()->id,
        ];
    }
}

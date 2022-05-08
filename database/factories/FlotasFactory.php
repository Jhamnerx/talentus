<?php

namespace Database\Factories;

use App\Models\Clientes;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlotasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre'  => $this->faker->unique()->name(),
            'clientes_id' => Clientes::all()->random()->id,
            'empresa_id' => Empresa::all()->random()->id,
        ];
    }
}

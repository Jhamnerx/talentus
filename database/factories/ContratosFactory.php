<?php

namespace Database\Factories;

use App\Models\Clientes;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContratosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'clientes_id' => Clientes::all()->random()->id,
            'fecha' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'empresa_id' => Empresa::all()->random()->id,

        ];
    }
}

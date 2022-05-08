<?php

namespace Database\Factories;

use App\Models\Clientes;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecibosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'numero' => $this->faker->ean8(),
            'fecha' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'total' => 100,
            'tipo_pago' => 'contado',
            'fecha_pago' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'nota' => $this->faker->sentence($nbWords = 16, $variableNbWords = true),
            'clientes_id' => Clientes::all()->random()->id,
            'empresa_id' => Empresa::all()->random()->id,
        ];
    }
}

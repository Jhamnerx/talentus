<?php

namespace Database\Factories;

use App\Models\Clientes;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class PresupuestosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $estado = array("0", "1", "2");
        $claves = array_rand($estado);
        return [
            'clientes_id' => Clientes::all()->random()->id,
            'numero' => $this->faker->unique()->ean8(),
            'fecha' => $this->faker->dateTimeBetween($endDate = '-2 years', $startDate = 'now'),
            'fecha_caducidad' => $this->faker->dateTimeBetween($endDate = '-2 years', $startDate = 'now'),
            'estado' => $estado[$claves],
            'empresa_id' => Empresa::all()->random()->id,

        ];
    }
}

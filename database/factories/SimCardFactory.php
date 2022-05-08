<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\Lineas;
use Illuminate\Database\Eloquent\Factories\Factory;

class SimCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $operadores = array("Claro", "Entel", "Movistar");
        $claves = array_rand($operadores);
        return [
            'sim_card' => $this->faker->unique()->ean13(),
            'lineas_id' => Lineas::all()->random()->id,
            'operador' => $operadores[$claves],
            'empresa_id' => Empresa::all()->random()->id,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class LineasFactory extends Factory
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
            'numero' => $this->faker->unique()->phoneNumber(),
            'operador' => $operadores[$claves],
            'empresa_id' => Empresa::all()->random()->id,
        ];
    }
}

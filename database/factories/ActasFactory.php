<?php

namespace Database\Factories;

use App\Models\Ciudades;
use App\Models\Empresa;
use App\Models\Vehiculos;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vehiculos_id' => Vehiculos::all()->random()->id,
            'numero' => '01',
            'inicio_cobertura' => '2022-04-17',
            'fin_cobertura' => '2022-05-17',
            'fecha' => 'Cajamarca, 07 de Noviembre del 2022.',
            'ciudades_id' => Ciudades::all()->random()->id,
            'year' => '22',
            'empresa_id' => Empresa::all()->random()->id,


        ];
    }
}

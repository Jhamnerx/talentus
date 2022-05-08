<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\ModelosDispositivo;
use Illuminate\Database\Eloquent\Factories\Factory;

class DispositivosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'imei' => $this->faker->unique()->isbn13(),
            'modelo_id' => ModelosDispositivo::all()->random()->id,
            'empresa_id' => Empresa::all()->random()->id,
        ];
    }
}

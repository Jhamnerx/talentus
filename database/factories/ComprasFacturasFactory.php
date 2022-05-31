<?php

namespace Database\Factories;

use App\Models\Clientes;
use App\Models\Empresa;
use App\Models\Proveedores;
use App\Scopes\EliminadoScope;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComprasFacturasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'serie' => 'FAC-',
            'numero' => $this->faker->ean8(),
            'fecha' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'fecha_vencimiento' => $this->faker->dateTimeBetween($endDate = '-2 years', $startDate = 'now'),
            'total' => 5411,
            'nota' => $this->faker->sentence($nbWords = 4, $variableNbWords = true),
            'proveedores_id' => Proveedores::all()->random()->id,
            'empresa_id' => Empresa::all()->random()->id,
        ];
    }
}

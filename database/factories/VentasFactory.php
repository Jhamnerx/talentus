<?php

namespace Database\Factories;

use App\Models\Clientes;
use App\Models\Empresa;
use App\Models\VentasFacturas;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VentasFacturas::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'serie' => 'FTC-',
            'numero' => $this->faker->ean8(),
            'fecha' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'fecha_vencimiento' => $this->faker->dateTimeBetween($endDate = '-2 years', $startDate = 'now'),
            'impuesto' => 18,
            'total' => 100,
            'sub_total' => 100,
            'tipo_pago' => 'contado',
            'nota' => $this->faker->sentence($nbWords = 16, $variableNbWords = true),
            'clientes_id' => Clientes::all()->random()->id,
            'empresa_id' => Empresa::all()->random()->id,
        ];
    }
}

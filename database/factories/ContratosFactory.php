<?php

namespace Database\Factories;

use App\Models\Ciudades;
use App\Models\Clientes;
use App\Models\Contratos;
use App\Models\Empresa;
use Vinkla\Hashids\Facades\Hashids;
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
            'ciudades_id' => Ciudades::all()->random()->id,
            'unique_hash' => Hashids::connection(Contratos::class)->encode($this->faker->ean13()),
        ];
    }
}

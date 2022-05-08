<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\Vehiculos;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportesFactory extends Factory
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
            'hora_t' => '14:19:53',
            'fecha_t' => '2022-04-17',
            'fecha' => '2022-04-18',
            'detalle' => '',
            'empresa_id' => Empresa::all()->random()->id,


        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Ciudades;
use App\Models\Clientes;
use App\Models\Dispositivos;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificadosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'numero' => '01',
            'fin_cobertura' => '2022-04-17',
            'fecha' => 'Cajamarca, 07 de Noviembre del 2022.',
            'year' => '22',
            'clientes_id' => Clientes::all()->random()->id,
            'ciudades_id' => Ciudades::all()->random()->id,
            'dispositivos_id' => Dispositivos::all()->random()->id,
            'empresa_id' => Empresa::all()->random()->id,


        ];
    }
}

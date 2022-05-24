<?php

namespace Database\Factories;

use App\Models\Certificados;
use App\Models\Ciudades;
use App\Models\Clientes;
use App\Models\Dispositivos;
use App\Models\Empresa;
use App\Models\Vehiculos;
use Vinkla\Hashids\Facades\Hashids;
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
            'ciudades_id' => Ciudades::all()->random()->id,
            'empresa_id' => Empresa::all()->random()->id,
            'vehiculos_id' => Vehiculos::all()->random()->id,
            'unique_hash' => Hashids::connection(Certificados::class)->encode(),


        ];
    }
}

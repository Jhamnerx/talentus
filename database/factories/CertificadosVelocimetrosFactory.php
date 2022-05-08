<?php

namespace Database\Factories;

use App\Models\CertificadosVelocimetros;
use App\Models\Empresa;
use App\Models\Vehiculos;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificadosVelocimetrosFactory extends Factory
{
    //Definir modelo
    protected $model = CertificadosVelocimetros::class;
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
            'fecha' => 'Cajamarca, 07 de Noviembre del 2022.',
            'year' => '22',
            'empresa_id' => Empresa::all()->random()->id,



        ];
    }
}

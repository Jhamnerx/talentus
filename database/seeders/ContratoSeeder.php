<?php

namespace Database\Seeders;

use App\Models\Contratos;
use App\Models\DetalleContratos;
use App\Models\Vehiculos;
use Illuminate\Database\Seeder;

class ContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contratos = Contratos::factory(100)->create();

        foreach ($contratos as $contrato) {


            DetalleContratos::create([
                'contratos_id' => $contrato->id,
                'vehiculos_id' => Vehiculos::all()->random()->id,
                'plan' => '50',
            ]);
            DetalleContratos::create([
                'contratos_id' => $contrato->id,
                'vehiculos_id' => Vehiculos::all()->random()->id,
                'plan' => '50',
            ]);
        }
    }
}

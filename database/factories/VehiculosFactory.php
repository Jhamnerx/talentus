<?php

namespace Database\Factories;

use App\Models\Dispositivos;
use App\Models\Empresa;
use App\Models\Flotas;
use App\Models\Lineas;
use App\Models\ModelosDispositivo;
use App\Models\SimCard;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\Cast\Array_;

class VehiculosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $marcas = array("MERCEDEZ", "TOYOTA", "ZINSAC", "YUEJIM", "WOLKSWAGEN", "VOLVO");
        $years = array('2019', '2020', '2021', '2022');
        $colores = array("VERDE", "AZUL", "ROJO", "ROJO AZUL", "BLANCO", "PLATA", "GRIS BLANCO", "ROJO BLANCO", "AZUL MARINO");

        $claves1 = array_rand($marcas);
        $claves2 = array_rand($years);
        $claves3 = array_rand($colores);


        return [
            'placa' => "AHF-987",
            'marca' => $marcas[$claves1],
            'modelo' => '',
            'year' => $years[$claves2],
            'color' => $colores[$claves3],
            'numero' => SimCard::all()->random()->id,
            'modelos_dispositivos_id' => ModelosDispositivo::all()->random()->id,
            'flotas_id' => Flotas::all()->random()->id,
            'dispositivos_id' => Dispositivos::all()->random()->id,
            'empresa_id' => Empresa::all()->random()->id,

        ];
    }
}

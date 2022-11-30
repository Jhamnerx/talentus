<?php

namespace Database\Seeders;

use App\Models\Imagen;
use App\Models\ModelosDispositivo;
use Illuminate\Database\Seeder;

class ModelosDispositivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelosDispositivo::create([
            'modelo' => 'FMB920',
            'marca' => 'TELTONIKA',
            'certificado' => 'TRFM23655',
            'caracteristicas' => [
                ["text" => "Teltonika FMB920 es un rastreador compacto e inteligente con conectividad Bluetooth, alta ganancia interna, Antenas GNSS y GSM y bater\u00eda de respaldo integrada. Tecnolog\u00eda 2G"],
                ["text" => "50 gerocercas, Detecci\u00f3n de viaje, detecci\u00f3n de colisiones seg\u00fan los datos del aceler\u00f3metro."],
                ["text" => "Detecci\u00f3n de desconexi\u00f3n GNSS, descarga de DDD y datos en l\u00ednea de Tacho, seguimiento fuera de l\u00ednea."],
                ["text" => "Deteccion de estados de conduccion, detecci\u00f3n de exceso de velocidad, detecci\u00f3n de interferencias"],
                ["text" => "Memoria interna 128mg y bater\u00eda de respaldo."],
                ["text" => "Transmisi\u00f3n de datos al minuto y al momento que ocurre alg\u00fan evento en tiempo real."]
            ],
        ]);
        ModelosDispositivo::create([
            'modelo' => 'FMC130-4G',
            'marca' => 'TELTONIKA',
            'certificado' => 'TRFM23655',
            'caracteristicas' => [
                ["text" => "Teltonika FMB920 es un rastreador compacto e inteligente con conectividad Bluetooth, alta ganancia interna, Antenas GNSS y GSM y bater\u00eda de respaldo integrada. Tecnolog\u00eda 2G"],
                ["text" => "50 gerocercas, Detecci\u00f3n de viaje, detecci\u00f3n de colisiones seg\u00fan los datos del aceler\u00f3metro."],
                ["text" => "Detecci\u00f3n de desconexi\u00f3n GNSS, descarga de DDD y datos en l\u00ednea de Tacho, seguimiento fuera de l\u00ednea."],
                ["text" => "Deteccion de estados de conduccion, detecci\u00f3n de exceso de velocidad, detecci\u00f3n de interferencias"],
                ["text" => "Memoria interna 128mg y bater\u00eda de respaldo."],
                ["text" => "Transmisi\u00f3n de datos al minuto y al momento que ocurre alg\u00fan evento en tiempo real."]
            ],
        ]);
        ModelosDispositivo::create([
            'modelo' => 'TK-318',
            'marca' => 'TELTONIKA',
            'certificado' => 'TRFM23655',
            'caracteristicas' => [
                ["text" => "Teltonika FMB920 es un rastreador compacto e inteligente con conectividad Bluetooth, alta ganancia interna, Antenas GNSS y GSM y bater\u00eda de respaldo integrada. Tecnolog\u00eda 2G"],
                ["text" => "50 gerocercas, Detecci\u00f3n de viaje, detecci\u00f3n de colisiones seg\u00fan los datos del aceler\u00f3metro."],
                ["text" => "Detecci\u00f3n de desconexi\u00f3n GNSS, descarga de DDD y datos en l\u00ednea de Tacho, seguimiento fuera de l\u00ednea."],
                ["text" => "Deteccion de estados de conduccion, detecci\u00f3n de exceso de velocidad, detecci\u00f3n de interferencias"],
                ["text" => "Memoria interna 128mg y bater\u00eda de respaldo."],
                ["text" => "Transmisi\u00f3n de datos al minuto y al momento que ocurre alg\u00fan evento en tiempo real."]
            ],

        ]);
        ModelosDispositivo::create([
            'modelo' => 'FMU130-3G',
            'marca' => 'TELTONIKA',
            'certificado' => 'TRFM23655',
            'caracteristicas' => [
                ["text" => "Teltonika FMB920 es un rastreador compacto e inteligente con conectividad Bluetooth, alta ganancia interna, Antenas GNSS y GSM y bater\u00eda de respaldo integrada. Tecnolog\u00eda 2G"],
                ["text" => "50 gerocercas, Detecci\u00f3n de viaje, detecci\u00f3n de colisiones seg\u00fan los datos del aceler\u00f3metro."],
                ["text" => "Detecci\u00f3n de desconexi\u00f3n GNSS, descarga de DDD y datos en l\u00ednea de Tacho, seguimiento fuera de l\u00ednea."],
                ["text" => "Deteccion de estados de conduccion, detecci\u00f3n de exceso de velocidad, detecci\u00f3n de interferencias"],
                ["text" => "Memoria interna 128mg y bater\u00eda de respaldo."],
                ["text" => "Transmisi\u00f3n de datos al minuto y al momento que ocurre alg\u00fan evento en tiempo real."]
            ],
        ]);


        $modelos = ModelosDispositivo::all();

        foreach ($modelos as $modelo) {
            Imagen::create([
                'url' => 'modelos_dispositivos/' . $modelo->modelo,
                'imageable_id' => $modelo->id,
                'imageable_type' => ModelosDispositivo::class,
            ]);
        }
    }
}

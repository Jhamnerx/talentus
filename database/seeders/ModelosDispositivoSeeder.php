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
                ["text" => "Teltonika FMB920 es un rastreador compacto e inteligente con conectividad Bluetooth, alta ganancia interna, Antenas GNSS y GSM y batería de respaldo integrada. Tecnología 2G"],
                ["text" => "50 gerocercas, Detección de viaje, detección de colisiones según los datos del acelerómetro."],
                ["text" => "Detección de desconexión GNSS, descarga de DDD y datos en línea de Tacho, seguimiento fuera de línea."],
                ["text" => "Deteccion de estados de conduccion, detección de exceso de velocidad, detección de interferencias"],
                ["text" => "Memoria interna 128mg y batería de respaldo."],
                ["text" => "Transmisión de datos al minuto y al momento que ocurre algún evento en tiempo real."]
            ],
        ]);
        ModelosDispositivo::create([
            'modelo' => 'FMC130-4G',
            'marca' => 'TELTONIKA',
            'certificado' => 'TRFM23655',
            'caracteristicas' => [
                ["text" => "Teltonika FMB920 es un rastreador compacto e inteligente con conectividad Bluetooth, alta ganancia interna, Antenas GNSS y GSM y batería de respaldo integrada. Tecnología 2G"],
                ["text" => "50 gerocercas, Detección de viaje, detección de colisiones según los datos del acelerómetro."],
                ["text" => "Detección de desconexión GNSS, descarga de DDD y datos en línea de Tacho, seguimiento fuera de línea."],
                ["text" => "Deteccion de estados de conduccion, detección de exceso de velocidad, detección de interferencias"],
                ["text" => "Memoria interna 128mg y batería de respaldo."],
                ["text" => "Transmisión de datos al minuto y al momento que ocurre algún evento en tiempo real."]
            ],
        ]);
        ModelosDispositivo::create([
            'modelo' => 'TK-318',
            'marca' => 'TELTONIKA',
            'certificado' => 'TRFM23655',
            'caracteristicas' => [
                ["text" => "Teltonika FMB920 es un rastreador compacto e inteligente con conectividad Bluetooth, alta ganancia interna, Antenas GNSS y GSM y batería de respaldo integrada. Tecnología 2G"],
                ["text" => "50 gerocercas, Detección de viaje, detección de colisiones según los datos del acelerómetro."],
                ["text" => "Detección de desconexión GNSS, descarga de DDD y datos en línea de Tacho, seguimiento fuera de línea."],
                ["text" => "Deteccion de estados de conduccion, detección de exceso de velocidad, detección de interferencias"],
                ["text" => "Memoria interna 128mg y batería de respaldo."],
                ["text" => "Transmisión de datos al minuto y al momento que ocurre algún evento en tiempo real."]
            ],

        ]);
        ModelosDispositivo::create([
            'modelo' => 'FMU130-3G',
            'marca' => 'TELTONIKA',
            'certificado' => 'TRFM23655',
            'caracteristicas' => [
                ["text" => "Teltonika FMB920 es un rastreador compacto e inteligente con conectividad Bluetooth, alta ganancia interna, Antenas GNSS y GSM y batería de respaldo integrada. Tecnología 2G"],
                ["text" => "50 gerocercas, Detección de viaje, detección de colisiones según los datos del acelerómetro."],
                ["text" => "Detección de desconexión GNSS, descarga de DDD y datos en línea de Tacho, seguimiento fuera de línea."],
                ["text" => "Deteccion de estados de conduccion, detección de exceso de velocidad, detección de interferencias"],
                ["text" => "Memoria interna 128mg y batería de respaldo."],
                ["text" => "Transmisión de datos al minuto y al momento que ocurre algún evento en tiempo real."]
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

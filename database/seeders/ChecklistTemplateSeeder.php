<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChecklistTemplate;
use App\Enums\ChecklistCategoria;

class ChecklistTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresa_id = 1; // Ajustar según tu estructura

        $templates = [
            // VEHICULO
            [
                'nombre' => 'Estado general de la carrocería',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Verificar abolladuras, rayones y estado de pintura',
                'requiere_foto' => true,
                'orden' => 1,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Limpieza del vehículo',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Estado de limpieza interior y exterior',
                'requiere_foto' => false,
                'orden' => 2,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Parabrisas y cristales',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Estado de parabrisas, luneta y cristales laterales',
                'requiere_foto' => true,
                'orden' => 3,
                'empresa_id' => $empresa_id,
            ],

            // TABLERO
            [
                'nombre' => 'Kilometraje actual',
                'categoria' => ChecklistCategoria::TABLERO,
                'descripcion' => 'Registrar kilometraje del odómetro',
                'requiere_foto' => true,
                'orden' => 10,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Nivel de combustible',
                'categoria' => ChecklistCategoria::TABLERO,
                'descripcion' => 'Registrar nivel de combustible',
                'requiere_foto' => false,
                'orden' => 11,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Luces de advertencia',
                'categoria' => ChecklistCategoria::TABLERO,
                'descripcion' => 'Verificar luces de check engine, batería, etc.',
                'requiere_foto' => true,
                'orden' => 12,
                'empresa_id' => $empresa_id,
            ],

            // LUCES
            [
                'nombre' => 'Luces delanteras',
                'categoria' => ChecklistCategoria::LUCES,
                'descripcion' => 'Estado de faros altos y bajos',
                'requiere_foto' => false,
                'orden' => 20,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Luces traseras y freno',
                'categoria' => ChecklistCategoria::LUCES,
                'descripcion' => 'Verificar funcionamiento de luces traseras',
                'requiere_foto' => false,
                'orden' => 21,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Direccionales',
                'categoria' => ChecklistCategoria::LUCES,
                'descripcion' => 'Verificar funcionamiento de direccionales',
                'requiere_foto' => false,
                'orden' => 22,
                'empresa_id' => $empresa_id,
            ],

            // ACCESORIOS
            [
                'nombre' => 'Botón de pánico',
                'categoria' => ChecklistCategoria::ACCESORIOS,
                'descripcion' => 'Verificar instalación y funcionamiento del botón de pánico',
                'requiere_foto' => true,
                'orden' => 30,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Sirena / Alarma',
                'categoria' => ChecklistCategoria::ACCESORIOS,
                'descripcion' => 'Verificar instalación y funcionamiento de sirena',
                'requiere_foto' => true,
                'orden' => 31,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Micrófono de audio',
                'categoria' => ChecklistCategoria::ACCESORIOS,
                'descripcion' => 'Verificar instalación y calidad de audio del micrófono',
                'requiere_foto' => false,
                'orden' => 32,
                'empresa_id' => $empresa_id,
            ],

            // MOTOR
            [
                'nombre' => 'Nivel de aceite',
                'categoria' => ChecklistCategoria::MOTOR,
                'descripcion' => 'Verificar nivel de aceite del motor',
                'requiere_foto' => false,
                'orden' => 40,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Estado de la batería',
                'categoria' => ChecklistCategoria::MOTOR,
                'descripcion' => 'Verificar estado y carga de batería',
                'requiere_foto' => false,
                'orden' => 41,
                'empresa_id' => $empresa_id,
            ],

            // NEUMATICOS
            [
                'nombre' => 'Estado de neumáticos',
                'categoria' => ChecklistCategoria::NEUMATICOS,
                'descripcion' => 'Verificar desgaste y presión de neumáticos',
                'requiere_foto' => true,
                'orden' => 50,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Llanta de repuesto',
                'categoria' => ChecklistCategoria::NEUMATICOS,
                'descripcion' => 'Verificar existencia y estado de llanta de repuesto',
                'requiere_foto' => false,
                'orden' => 51,
                'empresa_id' => $empresa_id,
            ],

            // DOCUMENTOS
            [
                'nombre' => 'SOAT vigente',
                'categoria' => ChecklistCategoria::DOCUMENTOS,
                'descripcion' => 'Verificar SOAT vigente',
                'requiere_foto' => true,
                'orden' => 60,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Revisión técnica vigente',
                'categoria' => ChecklistCategoria::DOCUMENTOS,
                'descripcion' => 'Verificar certificado de revisión técnica',
                'requiere_foto' => true,
                'orden' => 61,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Tarjeta de propiedad',
                'categoria' => ChecklistCategoria::DOCUMENTOS,
                'descripcion' => 'Verificar existencia de tarjeta de propiedad',
                'requiere_foto' => false,
                'orden' => 62,
                'empresa_id' => $empresa_id,
            ],
        ];

        foreach ($templates as $template) {
            ChecklistTemplate::create($template);
        }
    }
}

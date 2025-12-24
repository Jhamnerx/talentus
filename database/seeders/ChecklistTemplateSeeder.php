<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChecklistTemplate;
use App\Models\Empresa;
use App\Enums\ChecklistCategoria;

class ChecklistTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las empresas activas
        $empresas = Empresa::all();

        if ($empresas->isEmpty()) {
            $this->command->warn('⚠️  No hay empresas registradas. Por favor crea al menos una empresa antes de ejecutar este seeder.');
            return;
        }

        $templates = [
            // LUCES
            [
                'nombre' => 'Luces Delanteras',
                'categoria' => ChecklistCategoria::LUCES,
                'descripcion' => 'Verificar funcionamiento de luces delanteras (altas, bajas, direccionales)',
                'requiere_foto' => true,
                'orden' => 1,
            ],
            [
                'nombre' => 'Luces Posteriores',
                'categoria' => ChecklistCategoria::LUCES,
                'descripcion' => 'Verificar funcionamiento de luces posteriores (freno, reversa, direccionales)',
                'requiere_foto' => true,
                'orden' => 2,
            ],

            // TABLERO
            [
                'nombre' => 'Tablero - Estado General',
                'categoria' => ChecklistCategoria::TABLERO,
                'descripcion' => 'Verificar estado general del tablero de instrumentos',
                'requiere_foto' => true,
                'orden' => 3,
            ],
            [
                'nombre' => 'Tablero - Instrumentos',
                'categoria' => ChecklistCategoria::TABLERO,
                'descripcion' => 'Verificar funcionamiento de indicadores (velocímetro, RPM, combustible, temperatura)',
                'requiere_foto' => false,
                'orden' => 4,
            ],
            [
                'nombre' => 'Alarmas del Tablero',
                'categoria' => ChecklistCategoria::TABLERO,
                'descripcion' => 'Verificar funcionamiento de alarmas (check engine, aceite, batería, etc.)',
                'requiere_foto' => false,
                'orden' => 5,
            ],
            [
                'nombre' => 'Claxon Eléctrico',
                'categoria' => ChecklistCategoria::TABLERO,
                'descripcion' => 'Verificar funcionamiento del claxon',
                'requiere_foto' => false,
                'orden' => 6,
            ],

            // VEHICULO - EXTERIOR
            [
                'nombre' => 'Pintura - Estado',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Verificar estado de la pintura (rayones, abolladuras, oxidación)',
                'requiere_foto' => true,
                'orden' => 7,
            ],
            [
                'nombre' => 'Espejos Retrovisores',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Verificar estado y funcionamiento de espejos laterales y central',
                'requiere_foto' => true,
                'orden' => 8,
            ],
            [
                'nombre' => 'Emblemas',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Verificar presencia y estado de emblemas del vehículo',
                'requiere_foto' => true,
                'orden' => 9,
            ],
            [
                'nombre' => 'Antena',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Verificar presencia y estado de antena de radio',
                'requiere_foto' => false,
                'orden' => 10,
            ],

            // VEHICULO - INTERIOR
            [
                'nombre' => 'Interior - Tapiz',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Verificar estado del tapiz de asientos y techo',
                'requiere_foto' => true,
                'orden' => 11,
            ],
            [
                'nombre' => 'Limpieza Interior',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Verificar nivel de limpieza del habitáculo',
                'requiere_foto' => true,
                'orden' => 12,
            ],
            [
                'nombre' => 'Gavetas y Compartimentos',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Verificar funcionamiento de guantera, portavasos, compartimentos',
                'requiere_foto' => false,
                'orden' => 13,
            ],
            [
                'nombre' => 'Brazos y Plumillas',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Verificar estado de brazos y plumillas limpiaparabrisas',
                'requiere_foto' => true,
                'orden' => 14,
            ],
            [
                'nombre' => 'Pestillos Mecánicos/Eléctricos',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Verificar funcionamiento de seguros de puertas',
                'requiere_foto' => false,
                'orden' => 15,
            ],
            [
                'nombre' => 'Pisos (Jebes/Alfombras)',
                'categoria' => ChecklistCategoria::VEHICULO,
                'descripcion' => 'Verificar estado de pisos, alfombras y protecciones',
                'requiere_foto' => true,
                'orden' => 16,
            ],

            // ACCESORIOS
            [
                'nombre' => 'Llanta de Repuesto',
                'categoria' => ChecklistCategoria::ACCESORIOS,
                'descripcion' => 'Verificar presencia y estado de llanta de repuesto',
                'requiere_foto' => true,
                'orden' => 17,
            ],
            [
                'nombre' => 'Gata y Llave de Ruedas',
                'categoria' => ChecklistCategoria::ACCESORIOS,
                'descripcion' => 'Verificar presencia de gata hidráulica y llave de ruedas',
                'requiere_foto' => true,
                'orden' => 18,
            ],
            [
                'nombre' => 'Tapa de Tanque de Combustible',
                'categoria' => ChecklistCategoria::ACCESORIOS,
                'descripcion' => 'Verificar presencia y funcionamiento de tapa de combustible',
                'requiere_foto' => false,
                'orden' => 19,
            ],
            [
                'nombre' => 'Máscara de Radio',
                'categoria' => ChecklistCategoria::ACCESORIOS,
                'descripcion' => 'Verificar presencia y estado de máscara/marco del radio',
                'requiere_foto' => true,
                'orden' => 20,
            ],

            // DOCUMENTOS
            [
                'nombre' => 'Tarjeta de Propiedad',
                'categoria' => ChecklistCategoria::DOCUMENTOS,
                'descripcion' => 'Verificar presencia de tarjeta de propiedad vehicular',
                'requiere_foto' => false,
                'orden' => 21,
            ],
            [
                'nombre' => 'SOAT Vigente',
                'categoria' => ChecklistCategoria::DOCUMENTOS,
                'descripcion' => 'Verificar presencia y vigencia del Seguro Obligatorio de Accidentes de Tránsito',
                'requiere_foto' => false,
                'orden' => 22,
            ],

            // NEUMATICOS
            [
                'nombre' => 'Estado de Neumáticos',
                'categoria' => ChecklistCategoria::NEUMATICOS,
                'descripcion' => 'Verificar presión, desgaste y estado general de neumáticos',
                'requiere_foto' => true,
                'orden' => 23,
            ],

            // MOTOR
            [
                'nombre' => 'Nivel de Aceite',
                'categoria' => ChecklistCategoria::MOTOR,
                'descripcion' => 'Verificar nivel de aceite del motor',
                'requiere_foto' => false,
                'orden' => 24,
            ],
            [
                'nombre' => 'Nivel de Líquido Refrigerante',
                'categoria' => ChecklistCategoria::MOTOR,
                'descripcion' => 'Verificar nivel de refrigerante',
                'requiere_foto' => false,
                'orden' => 25,
            ],
        ];

        // Crear templates para cada empresa
        foreach ($empresas as $empresa) {
            $this->command->info("🏢 Creando checklist templates para empresa: {$empresa->nombre} (ID: {$empresa->id})");

            foreach ($templates as $template) {
                ChecklistTemplate::create(array_merge($template, [
                    'empresa_id' => $empresa->id,
                ]));
            }

            $this->command->info("✅ {$empresa->nombre}: 25 templates creados");
        }

        $totalCreated = $empresas->count() * count($templates);
        $this->command->info("🎉 Total: {$totalCreated} checklist templates creados para {$empresas->count()} empresa(s)");
    }
}

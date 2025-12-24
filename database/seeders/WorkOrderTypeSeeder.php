<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkOrderType;
use App\Models\Empresa;

class WorkOrderTypeSeeder extends Seeder
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

        $types = [
            [
                'nombre' => 'Instalación de GPS',
                'descripcion' => 'Instalación completa de dispositivo GPS con accesorios',
                'requiere_imei' => true,
                'requiere_sim' => true,
                'requiere_accesorios' => true,
                'requiere_checklist' => true,
                'costo_base' => 150.00,
            ],
            [
                'nombre' => 'Retiro de GPS',
                'descripcion' => 'Retiro completo de dispositivo GPS',
                'requiere_imei' => true,
                'requiere_sim' => false,
                'requiere_accesorios' => false,
                'requiere_checklist' => true,
                'costo_base' => 50.00,
            ],
            [
                'nombre' => 'Cambio de GPS',
                'descripcion' => 'Reemplazo de dispositivo GPS por otro',
                'requiere_imei' => true,
                'requiere_sim' => true,
                'requiere_accesorios' => false,
                'requiere_checklist' => true,
                'costo_base' => 80.00,
            ],
            [
                'nombre' => 'Cambio de SIM',
                'descripcion' => 'Reemplazo de tarjeta SIM del dispositivo',
                'requiere_imei' => false,
                'requiere_sim' => true,
                'requiere_accesorios' => false,
                'requiere_checklist' => false,
                'costo_base' => 30.00,
            ],
            [
                'nombre' => 'Mantenimiento preventivo',
                'descripcion' => 'Revisión y mantenimiento de dispositivo GPS instalado',
                'requiere_imei' => false,
                'requiere_sim' => false,
                'requiere_accesorios' => false,
                'requiere_checklist' => true,
                'costo_base' => 40.00,
            ],
            [
                'nombre' => 'Instalación de accesorios',
                'descripcion' => 'Instalación de accesorios adicionales (sirena, botón pánico, micrófono)',
                'requiere_imei' => false,
                'requiere_sim' => false,
                'requiere_accesorios' => true,
                'requiere_checklist' => true,
                'costo_base' => 60.00,
            ],
            [
                'nombre' => 'Reparación de GPS',
                'descripcion' => 'Reparación de dispositivo con fallas',
                'requiere_imei' => true,
                'requiere_sim' => false,
                'requiere_accesorios' => false,
                'requiere_checklist' => true,
                'costo_base' => 100.00,
            ],
        ];

        // Crear tipos para cada empresa
        foreach ($empresas as $empresa) {
            $this->command->info("🏢 Creando tipos de órdenes para empresa: {$empresa->nombre} (ID: {$empresa->id})");
            
            foreach ($types as $type) {
                WorkOrderType::create(array_merge($type, [
                    'empresa_id' => $empresa->id,
                ]));
            }
            
            $this->command->info("✅ {$empresa->nombre}: 7 tipos creados");
        }

        $totalCreated = $empresas->count() * count($types);
        $this->command->info("🎉 Total: {$totalCreated} tipos de órdenes creados para {$empresas->count()} empresa(s)");
    }
}

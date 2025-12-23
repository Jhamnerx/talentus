<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkOrderType;

class WorkOrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresa_id = 1; // Ajustar según tu estructura

        $types = [
            [
                'nombre' => 'Instalación de GPS',
                'descripcion' => 'Instalación completa de dispositivo GPS con accesorios',
                'requiere_imei' => true,
                'requiere_sim' => true,
                'requiere_accesorios' => true,
                'requiere_checklist' => true,
                'costo_base' => 150.00,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Retiro de GPS',
                'descripcion' => 'Retiro completo de dispositivo GPS',
                'requiere_imei' => true,
                'requiere_sim' => false,
                'requiere_accesorios' => false,
                'requiere_checklist' => true,
                'costo_base' => 50.00,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Cambio de GPS',
                'descripcion' => 'Reemplazo de dispositivo GPS por otro',
                'requiere_imei' => true,
                'requiere_sim' => true,
                'requiere_accesorios' => false,
                'requiere_checklist' => true,
                'costo_base' => 80.00,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Cambio de SIM',
                'descripcion' => 'Reemplazo de tarjeta SIM del dispositivo',
                'requiere_imei' => false,
                'requiere_sim' => true,
                'requiere_accesorios' => false,
                'requiere_checklist' => false,
                'costo_base' => 30.00,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Mantenimiento preventivo',
                'descripcion' => 'Revisión y mantenimiento de dispositivo GPS instalado',
                'requiere_imei' => false,
                'requiere_sim' => false,
                'requiere_accesorios' => false,
                'requiere_checklist' => true,
                'costo_base' => 40.00,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Instalación de accesorios',
                'descripcion' => 'Instalación de accesorios adicionales (sirena, botón pánico, micrófono)',
                'requiere_imei' => false,
                'requiere_sim' => false,
                'requiere_accesorios' => true,
                'requiere_checklist' => true,
                'costo_base' => 60.00,
                'empresa_id' => $empresa_id,
            ],
            [
                'nombre' => 'Reparación de GPS',
                'descripcion' => 'Reparación de dispositivo con fallas',
                'requiere_imei' => true,
                'requiere_sim' => false,
                'requiere_accesorios' => false,
                'requiere_checklist' => true,
                'costo_base' => 100.00,
                'empresa_id' => $empresa_id,
            ],
        ];

        foreach ($types as $type) {
            WorkOrderType::create($type);
        }
    }
}

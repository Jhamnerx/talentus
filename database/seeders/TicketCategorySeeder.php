<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\TicketCategory;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Obtener la primera empresa existente o advertir si no hay
        $empresa = Empresa::first();

        if (!$empresa) {
            $this->command->warn('No se encontraron empresas en la base de datos. Por favor cree una empresa primero.');
            return;
        }

        $categories = [
            ['name' => 'Soporte Técnico', 'description' => 'Problemas técnicos con equipos GPS o plataforma', 'color' => '#3B82F6', 'is_active' => true],
            ['name' => 'Consulta General', 'description' => 'Consultas sobre servicios o productos', 'color' => '#10B981', 'is_active' => true],
            ['name' => 'Reclamo', 'description' => 'Reclamos de clientes sobre servicios', 'color' => '#EF4444', 'is_active' => true],
            ['name' => 'Instalación', 'description' => 'Solicitudes de instalación de dispositivos', 'color' => '#8B5CF6', 'is_active' => true],
            ['name' => 'Mantenimiento', 'description' => 'Mantenimientos preventivos y correctivos', 'color' => '#F59E0B', 'is_active' => true],
            ['name' => 'Facturación', 'description' => 'Consultas sobre facturación y pagos', 'color' => '#06B6D4', 'is_active' => true],
            ['name' => 'Capacitación', 'description' => 'Solicitudes de capacitación sobre uso de plataforma', 'color' => '#EC4899', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            TicketCategory::create(array_merge($category, ['empresa_id' => $empresa->id]));
        }

        $this->command->info("Se crearon " . count($categories) . " categorías para la empresa: {$empresa->nombre}");
    }
}

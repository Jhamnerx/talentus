<?php

namespace Database\Seeders;

use App\Models\Productos;
use Illuminate\Database\Seeder;

class ServicioCobroSeeder extends Seeder
{
    /**
     * Marca o crea el producto de servicio de cobro.
     */
    public function run(): void
    {
        $empresaId = 1; // Empresa por defecto

        // Buscar si ya existe un producto de servicio
        $servicio = Productos::where('empresa_id', $empresaId)
            ->where('tipo', 'servicio')
            ->first();

        if ($servicio) {
            // Marcar el primer servicio encontrado sin disparar observers
            Productos::withoutEvents(function () use ($servicio) {
                $servicio->update(['es_servicio_cobro' => true]);
            });
            $this->command->info("✓ Producto '{$servicio->descripcion}' marcado como servicio de cobro.");
        } else {
            // Crear un nuevo servicio sin disparar observers
            $servicio = Productos::withoutEvents(function () use ($empresaId) {
                return Productos::create([
                    'empresa_id' => $empresaId,
                    'descripcion' => 'Servicio de Monitoreo GPS',
                    'tipo' => 'servicio',
                    'categoria_id' => 2, // Asume que 2 es categoría de servicios
                    'codigo' => 'SRV-001',
                    'unit_code' => 'ZZ',
                    'stock' => 0,
                    'valor_unitario' => 30.00,
                    'divisa' => 'PEN',
                    'is_active' => true,
                    'es_servicio_cobro' => true,
                    'es_dispositivo' => false,
                ]);
            });
            $this->command->info("✓ Servicio '{$servicio->descripcion}' creado y marcado como servicio de cobro.");
        }

        $this->command->info("\n¡Ahora puedes ejecutar: php artisan db:seed --class=PlanSeeder!");
    }
}

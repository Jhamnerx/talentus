<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Productos;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el producto que es servicio de cobro
        $servicioCobroProducto = Productos::getServicioCobro();

        if (!$servicioCobroProducto) {
            $this->command->error('No se encontró un producto marcado como servicio de cobro.');
            $this->command->info('Por favor, marca un producto como "servicio de cobro" antes de ejecutar este seeder.');
            return;
        }

        $empresaId = session('empresa') ?? 1; // Usar empresa de sesión o empresa con ID 1

        $this->command->info('Creando planes para empresa ID: ' . $empresaId);

        $planes = [
            [
                'producto_id' => $servicioCobroProducto->id,
                'empresa_id' => $empresaId,
                'name' => ['es' => 'Plan Básico', 'en' => 'Basic Plan'],
                'slug' => 'plan-basico',
                'description' => [
                    'es' => 'Plan básico de monitoreo GPS sin video',
                    'en' => 'Basic GPS monitoring plan without video'
                ],
                'is_active' => true,
                'price' => 30.00,
                'signup_fee' => 0.00,
                'currency' => 'PEN',
                'trial_period' => 0,
                'trial_interval' => 'day',
                'grace_period' => 3,
                'grace_interval' => 'day',
                'invoice_period' => 1,
                'invoice_interval' => 'month',
                'prorate_day' => null,
                'prorate_period' => null,
                'prorate_extend_due' => null,
                'active_subscribers_limit' => null,
                'sort_order' => 1,
            ],
            [
                'producto_id' => $servicioCobroProducto->id,
                'empresa_id' => $empresaId,
                'name' => ['es' => 'Plan Pro', 'en' => 'Pro Plan'],
                'slug' => 'plan-pro',
                'description' => [
                    'es' => 'Plan profesional con funciones avanzadas de monitoreo',
                    'en' => 'Professional plan with advanced monitoring features'
                ],
                'is_active' => true,
                'price' => 50.00,
                'signup_fee' => 0.00,
                'currency' => 'PEN',
                'trial_period' => 0,
                'trial_interval' => 'day',
                'grace_period' => 5,
                'grace_interval' => 'day',
                'invoice_period' => 1,
                'invoice_interval' => 'month',
                'prorate_day' => null,
                'prorate_period' => null,
                'prorate_extend_due' => null,
                'active_subscribers_limit' => null,
                'sort_order' => 2,
            ],
            [
                'producto_id' => $servicioCobroProducto->id,
                'empresa_id' => $empresaId,
                'name' => ['es' => 'Plan Premium', 'en' => 'Premium Plan'],
                'slug' => 'plan-premium',
                'description' => [
                    'es' => 'Plan premium con todas las funciones de monitoreo',
                    'en' => 'Premium plan with all monitoring features'
                ],
                'is_active' => true,
                'price' => 80.00,
                'signup_fee' => 0.00,
                'currency' => 'PEN',
                'trial_period' => 0,
                'trial_interval' => 'day',
                'grace_period' => 7,
                'grace_interval' => 'day',
                'invoice_period' => 1,
                'invoice_interval' => 'month',
                'prorate_day' => null,
                'prorate_period' => null,
                'prorate_extend_due' => null,
                'active_subscribers_limit' => null,
                'sort_order' => 3,
            ],
            [
                'producto_id' => $servicioCobroProducto->id,
                'empresa_id' => $empresaId,
                'name' => ['es' => 'Plan Premium + Video', 'en' => 'Premium + Video Plan'],
                'slug' => 'plan-premium-video',
                'description' => [
                    'es' => 'Plan premium con monitoreo por video en tiempo real',
                    'en' => 'Premium plan with real-time video monitoring'
                ],
                'is_active' => true,
                'price' => 120.00,
                'signup_fee' => 0.00,
                'currency' => 'PEN',
                'trial_period' => 0,
                'trial_interval' => 'day',
                'grace_period' => 7,
                'grace_interval' => 'day',
                'invoice_period' => 1,
                'invoice_interval' => 'month',
                'prorate_day' => null,
                'prorate_period' => null,
                'prorate_extend_due' => null,
                'active_subscribers_limit' => null,
                'sort_order' => 4,
            ],
            [
                'producto_id' => $servicioCobroProducto->id,
                'empresa_id' => $empresaId,
                'name' => ['es' => 'Plan Alojamiento Revendedor', 'en' => 'Reseller Hosting Plan'],
                'slug' => 'plan-alojamiento-revendedor',
                'description' => [
                    'es' => 'Plan especial para revendedores con alojamiento incluido',
                    'en' => 'Special plan for resellers with hosting included'
                ],
                'is_active' => true,
                'price' => 100.00,
                'signup_fee' => 0.00,
                'currency' => 'PEN',
                'trial_period' => 0,
                'trial_interval' => 'day',
                'grace_period' => 5,
                'grace_interval' => 'day',
                'invoice_period' => 1,
                'invoice_interval' => 'month',
                'prorate_day' => null,
                'prorate_period' => null,
                'prorate_extend_due' => null,
                'active_subscribers_limit' => null,
                'sort_order' => 5,
            ],
            [
                'producto_id' => $servicioCobroProducto->id,
                'empresa_id' => $empresaId,
                'name' => ['es' => 'Plan Hosting Monitoreo', 'en' => 'Monitoring Hosting Plan'],
                'slug' => 'plan-hosting-monitoreo',
                'description' => [
                    'es' => 'Plan de hosting dedicado para monitoreo GPS',
                    'en' => 'Dedicated hosting plan for GPS monitoring'
                ],
                'is_active' => true,
                'price' => 150.00,
                'signup_fee' => 0.00,
                'currency' => 'PEN',
                'trial_period' => 0,
                'trial_interval' => 'day',
                'grace_period' => 7,
                'grace_interval' => 'day',
                'invoice_period' => 1,
                'invoice_interval' => 'month',
                'prorate_day' => null,
                'prorate_period' => null,
                'prorate_extend_due' => null,
                'active_subscribers_limit' => null,
                'sort_order' => 6,
            ],
        ];

        foreach ($planes as $planData) {
            $plan = Plan::firstOrCreate(
                [
                    'slug' => $planData['slug'],
                    'empresa_id' => $empresaId,
                ],
                $planData
            );

            if ($plan->wasRecentlyCreated) {
                $this->command->info("✓ Plan creado: {$planData['name']['es']} (S/. {$planData['price']}/mes)");
            } else {
                $this->command->comment("- Plan ya existe: {$planData['name']['es']}");
            }
        }

        $this->command->info("\n¡Planes creados exitosamente!");
    }
}

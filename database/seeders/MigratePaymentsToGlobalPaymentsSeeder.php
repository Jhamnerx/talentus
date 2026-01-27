<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payments;
use App\Models\GlobalPayment;
use App\Models\Cash;

class MigratePaymentsToGlobalPaymentsSeeder extends Seeder
{
    /**
     * Migrar pagos existentes a global_payments
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando migración de pagos a GlobalPayments...');

        // Obtener todos los pagos que NO tienen GlobalPayment
        $payments = Payments::whereDoesntHave('globalPayment')
            ->with('paymentable')
            ->get();

        if ($payments->isEmpty()) {
            $this->command->warn('⚠️  No hay pagos para migrar');
            return;
        }

        $this->command->info("📊 Se encontraron {$payments->count()} pagos para migrar");

        $migrated = 0;
        $skipped = 0;

        foreach ($payments as $payment) {
            try {
                // Determinar el destino
                // Por defecto, buscar la caja del usuario
                $cash = Cash::where('user_id', $payment->user_id)
                    ->where('estado', 1)
                    ->first();

                if (!$cash) {
                    // Si no hay caja abierta, usar cualquier caja del usuario
                    $cash = Cash::where('user_id', $payment->user_id)->first();
                }

                if ($cash) {
                    GlobalPayment::create([
                        'destination_id' => $cash->id,
                        'destination_type' => Cash::class,
                        'payment_id' => $payment->id,
                        'payment_type' => get_class($payment),
                        'user_id' => $payment->user_id,
                        'empresa_id' => $payment->empresa_id ?? session('empresa', 1),
                        'created_at' => $payment->created_at,
                        'updated_at' => $payment->updated_at,
                    ]);

                    $migrated++;
                } else {
                    $this->command->warn("⚠️  Pago ID {$payment->id} no tiene caja asociada - omitido");
                    $skipped++;
                }
            } catch (\Exception $e) {
                $this->command->error("❌ Error migrando pago ID {$payment->id}: {$e->getMessage()}");
                $skipped++;
            }
        }

        $this->command->info("✅ Migración completada:");
        $this->command->info("   - Migrados: {$migrated}");
        $this->command->info("   - Omitidos: {$skipped}");
    }
}

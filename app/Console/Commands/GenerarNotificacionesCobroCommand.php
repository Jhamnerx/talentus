<?php

namespace App\Console\Commands;

use App\Jobs\GenerarNotificacionesCobro;
use Illuminate\Console\Command;

/**
 * Comando para generar notificaciones de cobro manualmente
 * 
 * Uso:
 * php artisan cobros:generar-notificaciones
 * php artisan cobros:generar-notificaciones --dias=3
 */
class GenerarNotificacionesCobroCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cobros:generar-notificaciones 
                            {--dias=7 : Días de anticipación para generar notificaciones}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera notificaciones de cobro para DetalleCobros próximos a vencer';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dias = (int) $this->option('dias');

        $this->info("🚀 Generando notificaciones de cobro...");
        $this->info("📅 Días de anticipación: {$dias}");

        $this->newLine();

        try {
            // Despachar el job de forma síncrona para ver resultados inmediatos
            GenerarNotificacionesCobro::dispatchSync($dias);

            $this->newLine();
            $this->components->success('✅ Notificaciones generadas exitosamente');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->newLine();
            $this->components->error('❌ Error al generar notificaciones');
            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}

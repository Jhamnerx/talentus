<?php

namespace App\Console\Commands;

use App\Jobs\SincronizarVehiculosGpswox;
use Illuminate\Console\Command;

class SincronizarGpswoxCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gpswox:sincronizar {--empresa= : ID de la empresa (opcional)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronizar vehículos desde GPSWox a la base de datos local';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $empresaId = $this->option('empresa');

        if ($empresaId && !is_numeric($empresaId)) {
            $this->error('El ID de empresa debe ser un número');
            return Command::FAILURE;
        }

        $this->info('🚀 Iniciando sincronización GPSWox...');

        if ($empresaId) {
            $this->info("📍 Empresa ID: {$empresaId}");
        } else {
            $this->info("📍 Sincronizando todas las empresas");
        }

        try {
            // Ejecutar sincronización de forma síncrona para mostrar resultado inmediato
            $job = new SincronizarVehiculosGpswox($empresaId ? (int)$empresaId : null);
            $job->handle();

            $this->newLine();
            $this->info('✅ Sincronización completada exitosamente');
            $this->info('📧 Se ha enviado una notificación a los administradores');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Error durante la sincronización:');
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}

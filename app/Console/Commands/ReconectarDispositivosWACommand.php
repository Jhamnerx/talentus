<?php

namespace App\Console\Commands;

use App\Jobs\ReconectarDispositivosWA;
use Illuminate\Console\Command;

class ReconectarDispositivosWACommand extends Command
{
    protected $signature = 'whatsapp:reconectar';

    protected $description = 'Reconecta dispositivos WhatsApp desconectados y mantiene activas las sesiones';

    public function handle(): int
    {
        $this->info('Ejecutando reconexión de dispositivos WhatsApp...');

        (new ReconectarDispositivosWA())->handle();

        $this->info('Proceso finalizado. Revisa los logs para más detalles.');

        return self::SUCCESS;
    }
}

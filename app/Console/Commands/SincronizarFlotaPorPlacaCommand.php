<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Vehiculos;
use App\Scopes\EmpresaScope;
use App\Services\GpsWoxService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SincronizarFlotaPorPlacaCommand extends Command
{
    protected $signature = 'gpswox:sincronizar-flota
                            {--delay=800 : Milisegundos de espera entre cada consulta a la API}';

    protected $description = 'Sincroniza vehículos con GPSWox consultando placa por placa (IMEI, SIM, gpswox_id)';

    public function handle(): int
    {
        $delayMs = (int) $this->option('delay');

        $vehiculos = Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->orderBy('id')
            ->get(['id', 'placa', 'empresa_id']);

        $total = $vehiculos->count();

        if ($total === 0) {
            $this->warn('No hay vehículos registrados.');
            return Command::SUCCESS;
        }

        $this->info("Sincronizando {$total} vehículos con GPSWox...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $service       = app(GpsWoxService::class);
        $encontrados   = 0;
        $noEncontrados = [];

        foreach ($vehiculos as $base) {
            $vehiculo = Vehiculos::withoutGlobalScope(EmpresaScope::class)->find($base->id);

            if (! $vehiculo) {
                $bar->advance();
                continue;
            }

            $resultado = $service->sincronizarVehiculoDesdePlataforma($vehiculo);

            if ($resultado['status'] === 1) {
                $encontrados++;
            } else {
                $noEncontrados[] = [
                    'placa'   => $base->placa,
                    'mensaje' => $resultado['message'] ?? 'No encontrado',
                ];
            }

            $bar->advance();

            if ($delayMs > 0) {
                usleep($delayMs * 1000);
            }
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Encontrados y sincronizados: {$encontrados}/{$total}");

        if (! empty($noEncontrados)) {
            $this->warn('Placas NO encontradas en GPSWox (' . count($noEncontrados) . '):');
            foreach ($noEncontrados as $item) {
                $this->line("  - {$item['placa']}: {$item['mensaje']}");
            }
        }

        Log::channel('daily')->info('[SincronizarFlota] Sincronización diaria completada', [
            'total'          => $total,
            'encontrados'    => $encontrados,
            'no_encontrados' => count($noEncontrados),
            'faltantes'      => array_column($noEncontrados, 'placa'),
        ]);

        return Command::SUCCESS;
    }
}

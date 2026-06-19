<?php

namespace App\Console\Commands;

use App\Models\ChsHistorico;
use App\Models\Clientes;
use App\Scopes\EmpresaScope;
use App\Services\Chs\ChsCalculatorService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class CalcularChsMensualCommand extends Command
{
    protected $signature = 'chs:calcular-mensual';

    protected $description = 'Calcula el Customer Health Score mensual de todos los clientes (todas las empresas)';

    public function handle(ChsCalculatorService $calculator): int
    {
        $periodo = Carbon::now()->startOfMonth();

        $procesados = 0;
        $conScore = 0;
        $omitidos = 0;
        $conError = 0;

        Clientes::withoutGlobalScope(EmpresaScope::class)->cursor()->each(function (Clientes $cliente) use ($calculator, $periodo, &$procesados, &$conScore, &$omitidos, &$conError) {
            $procesados++;

            try {
                $resultado = $calculator->calcularParaCliente($cliente);

                if ($resultado === null) {
                    $omitidos++;
                    return;
                }

                ChsHistorico::withoutGlobalScope(EmpresaScope::class)->updateOrCreate(
                    ['cliente_id' => $cliente->id, 'periodo' => $periodo->toDateString()],
                    [
                        'empresa_id' => $cliente->empresa_id,
                        'score_final' => $resultado['score_final'],
                        'categoria' => $resultado['categoria']->value,
                        'factores_detalle' => $resultado['factores_detalle'],
                    ]
                );

                $conScore++;
            } catch (Throwable $e) {
                $conError++;
                Log::error("CHS: error calculando cliente {$cliente->id}: {$e->getMessage()}", [
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        });

        $this->info("CHS mensual: {$procesados} clientes procesados, {$conScore} con score, {$omitidos} omitidos por falta de datos, {$conError} con error.");

        return Command::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Recibos;
use Illuminate\Console\Command;

class BackfillFechaPagoRecibos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backfill-fecha-pago-recibos {--dry-run : Muestra los cambios sin guardarlos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza recibos.fecha_pago con la fecha del último pago real registrado (solo recibos con pagos). Ventas no tiene columna fecha_pago.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        $recibos = Recibos::withoutGlobalScopes()
            ->whereHas('payments')
            ->with(['payments' => fn ($q) => $q->orderByDesc('fecha')->orderByDesc('id')])
            ->get();

        $actualizados = 0;
        $sinCambio    = 0;

        foreach ($recibos as $recibo) {
            $ultimoPago = $recibo->payments->first();

            if (!$ultimoPago || !$ultimoPago->fecha) {
                continue;
            }

            $nueva   = $ultimoPago->fecha->format('Y-m-d');
            $anterior = $recibo->fecha_pago?->format('Y-m-d');

            if ($nueva === $anterior) {
                $sinCambio++;
                continue;
            }

            $this->line(sprintf(
                '  %s-%s  %s  →  %s',
                $recibo->serie,
                $recibo->numero,
                $anterior ?? '(vacío)',
                $nueva
            ));

            if (!$dryRun) {
                $recibo->update(['fecha_pago' => $ultimoPago->fecha]);
            }

            $actualizados++;
        }

        $this->newLine();
        $this->info(($dryRun ? '[DRY-RUN] ' : '') . "Recibos con pagos: {$recibos->count()} | A actualizar: {$actualizados} | Ya correctos: {$sinCambio}");

        if ($dryRun && $actualizados > 0) {
            $this->comment('Ejecuta sin --dry-run para aplicar los cambios.');
        }

        return self::SUCCESS;
    }
}

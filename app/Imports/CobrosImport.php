<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\CobroEstado;
use App\Models\Clientes;
use App\Models\Cobros;
use App\Models\Plan;
use App\Models\Vehiculos;
use App\Scopes\EmpresaScope;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

/**
 * Importa cobros desde un Excel de respaldo.
 *
 * Columnas esperadas (fila 1 = cabecera, ignorada):
 *   0  CLIENTE            razon_social del cliente
 *   1  PLACA              placa del vehículo
 *   2  PLAN               nombre del plan
 *   3  PERÍODO            MENSUAL / TRIMESTRAL / ANUAL …
 *   4  TIPO COMPROBANTE   FACTURA / RECIBO
 *   5  MONTO PLAN         importe
 *   6  DESCUENTO          descuento
 *   7  DIVISA             PEN / USD
 *   8  FECHA INICIO       d/m/Y
 *   9  FECHA VENCIMIENTO  d/m/Y
 *  10  DÍAS RESTANTES     (ignorado)
 *  11  ESTADO             ACTIVO / SUSPENDIDO / CANCELADO
 *
 * Las filas de agrupación (ej. "41 vehículo(s)") se omiten automáticamente.
 */
class CobrosImport implements ToCollection, WithStartRow, SkipsEmptyRows
{
    public int   $importados = 0;
    public int   $omitidos   = 0;
    public array $errores    = [];

    private int $empresaId;

    public function __construct(int $empresaId)
    {
        $this->empresaId = $empresaId;
    }

    public function startRow(): int
    {
        return 2; // la fila 1 es la cabecera
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            $fila  = $index + 2; // número de fila real (base 1)
            $placa = trim((string) ($row[1] ?? ''));

            // Omitir filas de agrupación ("41 vehículo(s)") y filas vacías
            if ($placa === '' || mb_stripos($placa, 'veh') !== false) {
                $this->omitidos++;
                continue;
            }

            $clienteNombre  = trim((string) ($row[0]  ?? ''));
            $planNombre     = trim((string) ($row[2]  ?? ''));
            $periodo        = strtoupper(trim((string) ($row[3]  ?? 'MENSUAL')));
            $tipoComp       = strtoupper(trim((string) ($row[4]  ?? 'FACTURA')));
            $monto          = (float) ($row[5] ?? 0);
            $descuento      = (float) ($row[6] ?? 0);
            $divisa         = strtoupper(trim((string) ($row[7]  ?? 'PEN')));
            $fechaInicioRaw = trim((string) ($row[8]  ?? ''));
            $fechaFinRaw    = trim((string) ($row[9]  ?? ''));
            $estadoRaw      = strtoupper(trim((string) ($row[11] ?? 'ACTIVO')));

            try {
                // ── Buscar cliente ────────────────────────────────────────────
                $cliente = Clientes::withoutGlobalScope(EmpresaScope::class)
                    ->where('empresa_id', $this->empresaId)
                    ->where('razon_social', $clienteNombre)
                    ->first();

                if (!$cliente) {
                    $this->errores[] = "Fila {$fila}: Cliente no encontrado → \"{$clienteNombre}\"";
                    $this->omitidos++;
                    continue;
                }

                // ── Buscar vehículo ────────────────────────────────────────────
                $vehiculo = Vehiculos::withoutGlobalScope(EmpresaScope::class)
                    ->where('empresa_id', $this->empresaId)
                    ->where('placa', $placa)
                    ->first();

                if (!$vehiculo) {
                    $this->errores[] = "Fila {$fila}: Vehículo no encontrado → {$placa}";
                    $this->omitidos++;
                    continue;
                }

                // ── Buscar plan ────────────────────────────────────────────────
                $plan = null;
                if ($planNombre !== '' && strtolower($planNombre) !== 'sin plan') {
                    $plan = Plan::withoutGlobalScope(EmpresaScope::class)
                        ->where('empresa_id', $this->empresaId)
                        ->where('name', 'like', '%' . $planNombre . '%')
                        ->first();
                }

                // ── Parsear fechas (d/m/Y o fallback con Carbon::parse) ────────
                $fechaInicio = $this->parsearFecha($fechaInicioRaw, $fila);
                $fechaFin    = $this->parsearFecha($fechaFinRaw,    $fila);

                // ── Mapear estado ──────────────────────────────────────────────
                $estado = match ($estadoRaw) {
                    'SUSPENDIDO' => CobroEstado::SUSPENDIDO,
                    'CANCELADO'  => CobroEstado::CANCELADO,
                    'CORTESIA'   => CobroEstado::CORTESIA,
                    default      => CobroEstado::ACTIVO,
                };

                // ── Crear o actualizar el cobro ───────────────────────────────
                Cobros::withoutGlobalScope(EmpresaScope::class)
                    ->updateOrCreate(
                        [
                            'empresa_id'   => $this->empresaId,
                            'vehiculos_id' => $vehiculo->id,
                        ],
                        [
                            'clientes_id'       => $cliente->id,
                            'plan_id'           => $plan?->id,
                            'periodo'           => $periodo,
                            'monto'             => $monto,
                            'descuento'         => $descuento,
                            'divisa'            => $divisa,
                            'tipo_pago'         => $tipoComp,
                            'fecha_inicio'      => $fechaInicio,
                            'fecha_vencimiento' => $fechaFin,
                            'estado'            => $estado,
                        ]
                    );

                $this->importados++;
            } catch (\Throwable $e) {
                $this->errores[] = "Fila {$fila}: {$e->getMessage()}";
                $this->omitidos++;
            }
        }
    }

    private function parsearFecha(string $raw, int $fila): ?string
    {
        if ($raw === '' || $raw === '—' || $raw === '-') {
            return null;
        }

        // Formato d/m/Y (22/05/2026)
        try {
            return Carbon::createFromFormat('d/m/Y', $raw)->format('Y-m-d');
        } catch (\Exception) {
            // ignore
        }

        // Fallback: dejar que Carbon intente parsearlo
        try {
            return Carbon::parse($raw)->format('Y-m-d');
        } catch (\Exception) {
            $this->errores[] = "Fila {$fila}: Fecha no reconocida → \"{$raw}\"";
            return null;
        }
    }
}

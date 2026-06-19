<?php

namespace App\Services\Chs;

use App\Enums\ChsCategoria;
use App\Models\Clientes;
use Carbon\Carbon;

class ChsCalculatorService
{
    private const PESOS = [
        'pagos' => 25,
        'tickets' => 20,
        'gps' => 15,
        'antiguedad' => 10,
        'whatsapp' => 10,
        'resenas' => 10,
        'ordenes_trabajo' => 10,
    ];

    /**
     * @return array{score_final: int, categoria: ChsCategoria, factores_detalle: array<string, array{subscore: float|null, peso_aplicado: float}>}|null
     */
    public function calcularParaCliente(Clientes $cliente): ?array
    {
        $subscores = [
            'pagos' => $this->calcularFactorPagos($cliente),
            'tickets' => $this->calcularFactorTickets($cliente),
            'gps' => $this->calcularFactorGps($cliente),
            'antiguedad' => $this->calcularFactorAntiguedad($cliente),
            'whatsapp' => $this->calcularFactorWhatsapp($cliente),
            'resenas' => $this->calcularFactorResenas($cliente),
            'ordenes_trabajo' => $this->calcularFactorOrdenesTrabajo($cliente),
        ];

        return $this->combinarFactores($subscores);
    }

    /**
     * @param array<string, float|null> $subscores
     * @return array{score_final: int, categoria: ChsCategoria, factores_detalle: array<string, array{subscore: float|null, peso_aplicado: float}>}|null
     */
    private function combinarFactores(array $subscores): ?array
    {
        $disponibles = array_filter($subscores, fn (?float $valor) => $valor !== null);

        if (empty($disponibles)) {
            return null;
        }

        $pesoTotalDisponible = array_sum(array_intersect_key(self::PESOS, $disponibles));

        $scoreFinal = 0.0;
        $factoresDetalle = [];

        foreach ($subscores as $factor => $subscore) {
            if ($subscore === null) {
                $factoresDetalle[$factor] = ['subscore' => null, 'peso_aplicado' => 0.0];
                continue;
            }

            $pesoAplicado = self::PESOS[$factor] / $pesoTotalDisponible * 100;
            $scoreFinal += $subscore * ($pesoAplicado / 100);
            $factoresDetalle[$factor] = ['subscore' => round($subscore, 1), 'peso_aplicado' => round($pesoAplicado, 1)];
        }

        $scoreFinal = (int) round($scoreFinal);

        return [
            'score_final' => $scoreFinal,
            'categoria' => ChsCategoria::paraScore($scoreFinal),
            'factores_detalle' => $factoresDetalle,
        ];
    }

    private function calcularFactorPagos(Clientes $cliente): ?float
    {
        $cobrosActivos = $cliente->cobros()->activos()->get();

        if ($cobrosActivos->isEmpty()) {
            return null;
        }

        $alDia = $cobrosActivos->filter(fn ($cobro) => ! $cobro->vencido)->count();

        return 100 * $alDia / $cobrosActivos->count();
    }

    private function calcularFactorTickets(Clientes $cliente): ?float
    {
        $desde = Carbon::now()->subMonths(6);

        $tickets = $cliente->tickets()
            ->where('created_at', '>=', $desde)
            ->whereNotNull('due_at')
            ->get();

        if ($tickets->isEmpty()) {
            return null;
        }

        $vencidos = $tickets->filter(function ($ticket) {
            if ($ticket->resolved_at) {
                return $ticket->resolved_at->gt($ticket->due_at);
            }

            return $ticket->due_at->isPast();
        })->count();

        return 100 - (100 * $vencidos / $tickets->count());
    }

    private function calcularFactorGps(Clientes $cliente): ?float
    {
        $vehiculos = $cliente->vehiculos;

        if ($vehiculos->isEmpty()) {
            return null;
        }

        $activos = $vehiculos->where('gpswox_active', true)->count();

        return 100 * $activos / $vehiculos->count();
    }

    private function calcularFactorAntiguedad(Clientes $cliente): ?float
    {
        if (! $cliente->created_at) {
            return null;
        }

        $meses = $cliente->created_at->diffInMonths(Carbon::now());

        $base = match (true) {
            $meses < 6 => 40,
            $meses < 12 => 60,
            $meses < 36 => 80,
            default => 100,
        };

        $tieneContratoVigente = $cliente->contratos()->where('estado', true)->exists();

        return (float) ($tieneContratoVigente ? min(100, $base + 10) : $base);
    }

    private function calcularFactorWhatsapp(Clientes $cliente): ?float
    {
        $ultimaConversacion = $cliente->whatsappConversaciones()
            ->whereNotNull('last_message_at')
            ->latest('last_message_at')
            ->first();

        if (! $ultimaConversacion) {
            return null;
        }

        $dias = $ultimaConversacion->last_message_at->diffInDays(Carbon::now());

        return match (true) {
            $dias <= 7 => 100.0,
            $dias <= 30 => 70.0,
            $dias <= 90 => 40.0,
            default => 10.0,
        };
    }

    private function calcularFactorResenas(Clientes $cliente): ?float
    {
        $promedio = $cliente->resenas()
            ->whereNotNull('calificacion')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->avg('calificacion');

        if ($promedio === null) {
            return null;
        }

        return ((float) $promedio - 1) / 4 * 100;
    }

    private function calcularFactorOrdenesTrabajo(Clientes $cliente): ?float
    {
        $promedio = $cliente->ordenesTrabajo()
            ->whereNotNull('calificacion_cliente')
            ->where('calificado_at', '>=', Carbon::now()->subMonths(6))
            ->avg('calificacion_cliente');

        if ($promedio === null) {
            return null;
        }

        return ((float) $promedio - 1) / 4 * 100;
    }
}

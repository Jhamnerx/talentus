<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Ventas;
use App\Models\Recibos;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteVentasRecibosExport implements WithMultipleSheets
{
    use Exportable;

    public function __construct(
        public readonly string  $contexto,          // ventas | recibos | ambos
        public readonly string  $agrupacion,         // mensual | semanal
        public readonly string  $fecha_inicio,
        public readonly string  $fecha_fin,
        public readonly ?string $estado,
        public readonly ?string $tipo_comprobante_id,
        public readonly mixed  $cliente_id
    ) {}

    // ─── WithMultipleSheets ──────────────────────────────────────────────

    public function sheets(): array
    {
        $items = $this->fetchItems();

        if ($items->isEmpty()) {
            return [new ReportePeriodoSheet('Sin datos', collect(), $this->contexto)];
        }

        return $items
            ->groupBy('_group')
            ->map(fn($grupo, $label) => new ReportePeriodoSheet($label, $grupo, $this->contexto))
            ->values()
            ->toArray();
    }

    // ─── Query ───────────────────────────────────────────────────────────

    private function fetchItems(): Collection
    {
        $items = collect();

        if (in_array($this->contexto, ['ventas', 'ambos'])) {
            Ventas::query()
                ->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin])
                ->with(['cliente', 'user'])
                ->when(
                    $this->estado && $this->estado !== 'Todos',
                    fn($q) => $q->where('pago_estado', $this->estado)
                )
                ->when(
                    $this->tipo_comprobante_id,
                    fn($q) => $q->where('tipo_comprobante_id', $this->tipo_comprobante_id)
                )
                ->when(
                    $this->cliente_id,
                    fn($q) => $q->where('cliente_id', $this->cliente_id)
                )
                ->orderBy('fecha_emision')
                ->get()
                ->each(function ($v) use (&$items) {
                    $fecha = Carbon::parse($v->fecha_emision);
                    $base  = [
                        '_group' => $this->getGroupLabel($fecha),
                        '_sort'  => $fecha->format('Y-m-d'),
                    ];

                    if ($this->contexto === 'ventas') {
                        $items->push($base + [
                            $fecha->format('d/m/Y'),
                            $v->serie_correlativo ?? '',
                            $v->cliente?->razon_social ?? '',
                            $v->cliente?->numero_documento ?? '',
                            $v->forma_pago ?? '',
                            $v->op_gravadas,
                            $v->op_exoneradas,
                            $v->op_inafectas,
                            $v->sub_total,
                            $v->igv,
                            (float) $v->total,
                            $v->divisa === 'PEN' ? 'SOLES' : 'DOLARES',
                            $v->estado?->name ?? '',
                            $v->pago_estado === 'PAID' ? 'PAGADO' : 'PENDIENTE',
                            $v->user?->name ?? '',
                            $v->fe_mensaje_sunat ?? '',
                        ]);
                    } else {
                        $items->push($base + [
                            'VENTA',
                            $fecha->format('d/m/Y'),
                            $v->serie_correlativo ?? '',
                            $v->cliente?->razon_social ?? '',
                            $v->cliente?->numero_documento ?? '',
                            $v->forma_pago ?? '',
                            (float) $v->total,
                            $v->divisa === 'PEN' ? 'SOLES' : 'DOLARES',
                            $v->pago_estado === 'PAID' ? 'PAGADO' : 'PENDIENTE',
                        ]);
                    }
                });
        }

        if (in_array($this->contexto, ['recibos', 'ambos'])) {
            Recibos::query()
                ->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin])
                ->with(['clientes'])
                ->when(
                    $this->estado && $this->estado !== 'Todos',
                    fn($q) => $q->where('pago_estado', $this->estado)
                )
                ->when(
                    $this->cliente_id,
                    fn($q) => $q->where('clientes_id', $this->cliente_id)
                )
                ->orderBy('fecha_emision')
                ->get()
                ->each(function ($r) use (&$items) {
                    $fecha = Carbon::parse($r->fecha_emision);
                    $base  = [
                        '_group' => $this->getGroupLabel($fecha),
                        '_sort'  => $fecha->format('Y-m-d'),
                    ];

                    if ($this->contexto === 'recibos') {
                        $items->push($base + [
                            $fecha->format('d/m/Y'),
                            ($r->serie ?? '') . '-' . ($r->numero ?? ''),
                            $r->clientes?->razon_social ?? '',
                            $r->clientes?->numero_documento ?? '',
                            (float) $r->total,
                            $r->divisa === 'PEN' ? 'SOLES' : 'DOLARES',
                            $r->pago_estado === 'PAID' ? 'PAGADO' : 'PENDIENTE',
                            $r->fecha_pago?->format('d/m/Y') ?? '',
                        ]);
                    } else {
                        $items->push($base + [
                            'RECIBO',
                            $fecha->format('d/m/Y'),
                            ($r->serie ?? '') . '-' . ($r->numero ?? ''),
                            $r->clientes?->razon_social ?? '',
                            $r->clientes?->numero_documento ?? '',
                            '',
                            (float) $r->total,
                            $r->divisa === 'PEN' ? 'SOLES' : 'DOLARES',
                            $r->pago_estado === 'PAID' ? 'PAGADO' : 'PENDIENTE',
                        ]);
                    }
                });
        }

        return $items->sortBy('_sort')->values();
    }

    // ─── Helpers ─────────────────────────────────────────────────────────

    private function getGroupLabel(Carbon $fecha): string
    {
        if ($this->agrupacion === 'semanal') {
            $ini = $fecha->copy()->startOfWeek()->format('d-m-Y');
            $end = $fecha->copy()->endOfWeek()->format('d-m-Y');
            return "Sem {$ini} {$end}";
        }

        $meses = [
            1  => 'Enero',
            2  => 'Febrero',
            3  => 'Marzo',
            4  => 'Abril',
            5  => 'Mayo',
            6  => 'Junio',
            7  => 'Julio',
            8  => 'Agosto',
            9  => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        return $meses[$fecha->month] . ' ' . $fecha->year;
    }
}

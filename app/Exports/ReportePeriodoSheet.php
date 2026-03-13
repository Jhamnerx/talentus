<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportePeriodoSheet implements FromView, WithTitle, ShouldAutoSize
{
    public function __construct(
        private readonly string $label,
        private readonly Collection $items,
        private readonly string $contexto,
        private readonly int $maxPagos = 1,
    ) {}

    public function title(): string
    {
        $clean = preg_replace('/[\/\\\\\?\*\[\]:]+/', '-', $this->label);
        return mb_substr($clean, 0, 31);
    }

    public function view(): View
    {
        return view('exports.reporte-periodo', [
            'headings' => $this->buildHeadings(),
            'rows'     => $this->buildRows(),
        ]);
    }

    private function buildHeadings(): array
    {
        $prefix = match ($this->contexto) {
            'ventas' => [
                'FECHA EMISION',
                'COMPROBANTE',
                'CLIENTE',
                'RUC/DNI',
                'FORMA PAGO',
                'OP. GRAVADAS',
                'OP. EXONERADAS',
                'OP. INAFECTAS',
                'SUB TOTAL',
                'IGV',
                'TOTAL',
                'DIVISA',
                'ESTADO PAGO',
                'FECHA VENCIMIENTO',
                'DIAS RETRASO',
            ],
            'recibos' => [
                'FECHA EMISION',
                'N° RECIBO',
                'CLIENTE',
                'RUC/DNI',
                'FORMA PAGO',
                'TOTAL PEN (S/)',
                'TOTAL USD ($)',
                'ESTADO PAGO',
                'FECHA PAGO',
                'DIAS RETRASO',
            ],
            default => [
                'TIPO',
                'FECHA EMISION',
                'N° DOCUMENTO',
                'CLIENTE',
                'RUC/DNI',
                'FORMA PAGO',
                'OP. GRAVADAS',
                'OP. EXONERADAS',
                'OP. INAFECTAS',
                'SUB TOTAL',
                'IGV',
                'TOTAL',
                'DIVISA',
                'ESTADO PAGO',
                'FECHA VTO/PAGO',
                'DIAS RETRASO',
            ],
        };

        $paymentCols = [];
        for ($i = 1; $i <= $this->maxPagos; $i++) {
            $n = $this->maxPagos > 1 ? " $i" : '';
            $paymentCols[] = "PAGO{$n} - DESTINO / METODO";
            $paymentCols[] = "PAGO{$n} - MONTO / N° OP.";
        }

        $suffix = match ($this->contexto) {
            'ventas'  => ['VENDEDOR', 'ESTADO SUNAT', 'OBSERVACION', 'N° COMUNICACION BAJA', 'MOTIVO BAJA', 'N° NOTA CRÉDITO', 'SUSTENTO NC', 'ESTADO NC', 'ESTADO SUNAT NC'],
            'recibos' => [],
            default   => ['OBSERVACION', 'N° COMUNICACION BAJA', 'MOTIVO BAJA', 'N° NOTA CRÉDITO', 'SUSTENTO NC', 'ESTADO NC', 'ESTADO SUNAT NC'],
        };

        return array_merge($prefix, $paymentCols, $suffix);
    }

    private function buildRows(): array
    {
        $contexto = $this->contexto;
        $maxPagos = $this->maxPagos;

        return $this->items->map(function ($item) use ($contexto, $maxPagos) {
            $item     = (array) $item;
            $payments = $item['_payments'] ?? [];
            $suffix   = $item['_suffix']   ?? [];
            $base     = array_values(Arr::except($item, ['_group', '_sort', '_payments', '_suffix']));

            $observacion = '';
            if ($contexto === 'ventas' && isset($suffix[2])) {
                $observacion = $suffix[2];
            } elseif ($contexto !== 'recibos' && isset($suffix[0])) {
                $observacion = $suffix[0];
            }

            $paymentCols = [];
            for ($i = 0; $i < $maxPagos; $i++) {
                $p = $payments[$i] ?? null;
                $paymentCols[] = $p !== null ? ($p['label']     ?? '') : '';
                $paymentCols[] = $p !== null ? ($p['monto_ref'] ?? '') : '';
            }

            return [
                'cells'       => array_merge($base, $paymentCols, $suffix),
                'observacion' => $observacion,
            ];
        })->toArray();
    }
}

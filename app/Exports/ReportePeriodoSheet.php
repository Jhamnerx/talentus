<?php

namespace App\Exports;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportePeriodoSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithStyles
{
    public function __construct(
        private readonly string $label,
        private readonly Collection $items,
        private readonly string $contexto
    ) {}

    public function title(): string
    {
        // Sheet names: max 31 chars, no special chars
        $clean = preg_replace('/[\/\\\?\*\[\]:]+/', '-', $this->label);
        return mb_substr($clean, 0, 31);
    }

    public function headings(): array
    {
        return match ($this->contexto) {
            'ventas' => [
                'FECHA EMISION',
                'COMPROBANTE',
                'CLIENTE',
                'RUC',
                'FORMA PAGO',
                'OP. GRAVADAS',
                'OP. EXONERADAS',
                'OP. INAFECTAS',
                'SUB TOTAL',
                'IGV',
                'TOTAL',
                'DIVISA',
                'ESTADO',
                'ESTADO PAGO',
                'VENDEDOR',
                'SUNAT',
            ],
            'recibos' => [
                'FECHA EMISION',
                'N° RECIBO',
                'CLIENTE',
                'RUC',
                'TOTAL',
                'DIVISA',
                'ESTADO PAGO',
                'FECHA PAGO',
            ],
            default => [ // ambos
                'TIPO',
                'FECHA EMISION',
                'N° DOCUMENTO',
                'CLIENTE',
                'RUC',
                'FORMA PAGO',
                'TOTAL',
                'DIVISA',
                'ESTADO PAGO',
            ],
        };
    }

    public function collection(): Collection
    {
        return $this->items->map(
            fn($item) => array_values(Arr::except((array) $item, ['_group', '_sort']))
        );
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E40AF'],
                ],
            ],
        ];
    }
}

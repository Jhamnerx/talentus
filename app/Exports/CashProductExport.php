<?php

namespace App\Exports;

use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CashProductExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $cash;

    public function __construct(Cash $cash)
    {
        $this->cash = $cash;
        $this->cash->load([
            'cashDocuments.getDocumento.items.producto',
        ]);
    }

    public function collection()
    {
        $data = collect();

        // Header info
        $data->push(['REPORTE DE PRODUCTOS - CAJA CHICA']);
        $data->push(['Nombre:', $this->cash->nombre]);
        $data->push(['Usuario:', $this->cash->user->name]);
        $data->push(['Fecha:', $this->cash->fecha_apertura->format('d/m/Y')]);
        $data->push(['']);

        // Productos header
        $data->push(['PRODUCTOS VENDIDOS']);
        $data->push(['Producto', 'Documento', 'Cantidad', 'P. Unitario', 'Total']);

        $totalGeneral = 0;

        foreach ($this->cash->cashDocuments as $documento) {
            if ($documento->getDocumento && method_exists($documento->getDocumento, 'items')) {
                foreach ($documento->getDocumento->items as $item) {
                    $data->push([
                        $item->producto->nombre ?? $item->descripcion,
                        $documento->serie_numero ?? '-',
                        $item->cantidad,
                        number_format($item->precio_unitario, 2),
                        number_format($item->total, 2),
                    ]);

                    $totalGeneral += $item->total;
                }
            }
        }

        // Total
        $data->push(['']);
        $data->push(['', '', '', 'TOTAL:', number_format($totalGeneral, 2)]);

        return $data;
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Productos';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            6 => ['font' => ['bold' => true]],
            7 => ['font' => ['bold' => true]],
        ];
    }
}

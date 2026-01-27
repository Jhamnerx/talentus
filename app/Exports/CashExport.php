<?php

namespace App\Exports;

use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CashExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $cash;

    public function __construct(Cash $cash)
    {
        $this->cash = $cash;
        $this->cash->load([
            'cashDocuments.getDocumento',
            'cashDocuments.getTipoDocumento',
        ]);
    }

    public function collection()
    {
        $data = collect();

        // Header info
        $data->push(['REPORTE DE CAJA CHICA']);
        $data->push(['Nombre:', $this->cash->nombre]);
        $data->push(['Usuario:', $this->cash->user->name]);
        $data->push(['Fecha Apertura:', $this->cash->fecha_apertura->format('d/m/Y')]);
        if ($this->cash->fecha_cierre) {
            $data->push(['Fecha Cierre:', $this->cash->fecha_cierre->format('d/m/Y')]);
        }
        $data->push(['Moneda:', $this->cash->moneda]);
        $data->push(['']);

        // Documentos
        $data->push(['DOCUMENTOS REGISTRADOS']);
        $data->push(['Tipo', 'Documento', 'Fecha', 'Cliente/Proveedor', 'Monto', 'Tipo Mov.']);

        foreach ($this->cash->cashDocuments as $documento) {
            $esIngreso = $this->isIngreso($documento);

            $data->push([
                $documento->getTipoDocumento->descripcion ?? '-',
                $documento->serie_numero ?? '-',
                $documento->fecha_emision ? \Carbon\Carbon::parse($documento->fecha_emision)->format('d/m/Y') : '-',
                $documento->cliente_nombre ?? '-',
                number_format($documento->total, 2),
                $esIngreso ? 'INGRESO' : 'EGRESO',
            ]);
        }

        // Totales
        $totales = $this->cash->calcularTotales();
        $data->push(['']);
        $data->push(['TOTALES']);
        $data->push(['Saldo Inicial:', number_format($this->cash->saldo_inicial, 2)]);
        $data->push(['Total Ingresos:', number_format($totales['ingresos'], 2)]);
        $data->push(['Total Egresos:', number_format($totales['egresos'], 2)]);
        $data->push(['Saldo Final:', number_format($totales['saldo_final'], 2)]);

        return $data;
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Caja Chica';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            9 => ['font' => ['bold' => true]],
            10 => ['font' => ['bold' => true]],
        ];
    }

    private function isIngreso($documento): bool
    {
        if (!$documento->getDocumento) {
            return true;
        }

        if (method_exists($documento->getDocumento, 'isIncome')) {
            return $documento->getDocumento->isIncome();
        }

        return in_array($documento->document_type, [
            'App\Models\Recibos',
            'App\Models\Ventas',
            'App\Models\Facturas',
        ]);
    }
}

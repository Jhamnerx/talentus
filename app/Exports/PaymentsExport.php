<?php

namespace App\Exports;

use App\Models\Payments;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PaymentsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $search;
    protected $from;
    protected $to;
    protected $divisa;
    protected $payment_method_id;

    public function __construct($search, $from, $to, $divisa, $payment_method_id)
    {
        $this->search = $search;
        $this->from = $from;
        $this->to = $to;
        $this->divisa = $divisa;
        $this->payment_method_id = $payment_method_id;
    }

    public function query()
    {
        $desde = $this->from;
        $hasta = $this->to;

        return Payments::query()
            ->with(['paymentMethod', 'cobros', 'paymentable', 'user'])
            ->where(function ($query) {
                $query->where('numero', 'like', '%' . $this->search . '%')
                    ->orWhere('numero_operacion', 'like', '%' . $this->search . '%')
                    ->orWhere('documento', 'like', '%' . $this->search . '%')
                    ->orWhere('nota', 'like', '%' . $this->search . '%');
            })
            ->when(!empty($desde), function ($query) use ($desde, $hasta) {
                return $query->whereDate('fecha', '>=', $desde)
                    ->whereDate('fecha', '<=', $hasta);
            })
            ->when($this->divisa, function ($query) {
                return $query->where('divisa', $this->divisa);
            })
            ->when($this->payment_method_id, function ($query) {
                return $query->where('payment_method_id', $this->payment_method_id);
            })
            ->orderBy('documento', 'asc')
            ->orderBy('id', 'desc');
    }

    public function headings(): array
    {
        return [
            'NÚMERO',
            'FECHA',
            'N° OPERACIÓN',
            'TIPO DOCUMENTO',
            'N° DOCUMENTO',
            'MONTO PEN',
            'MONTO USD',
            'MÉTODO DE PAGO',
            'NOTA',
            'USUARIO',
        ];
    }

    public function map($payment): array
    {
        // Obtener información del documento relacionado
        $tipoDocumento = '-';
        $numeroDocumento = $payment->documento ?? '-';

        if ($payment->paymentable) {
            if ($payment->paymentable_type === 'App\\Models\\Ventas') {
                // Identificar tipo de comprobante según código
                $tipoComprobanteId = $payment->paymentable->tipo_comprobante_id;
                if ($tipoComprobanteId === '01') {
                    $tipoDocumento = 'FACTURA';
                } elseif ($tipoComprobanteId === '03') {
                    $tipoDocumento = 'BOLETA';
                } else {
                    $tipoDocumento = 'VENTA';
                }
                $numeroDocumento = $payment->paymentable->serie_correlativo ?? '-';
            } elseif ($payment->paymentable_type === 'App\\Models\\Recibos') {
                $tipoDocumento = 'RECIBO';
                $numeroDocumento = $payment->paymentable->serie_numero ?? '-';
            }
        }

        // Separar montos por divisa
        $montoPEN = $payment->divisa === 'PEN' ? $payment->monto : '';
        $montoUSD = $payment->divisa === 'USD' ? $payment->monto : '';

        return [
            $payment->numero,
            $payment->fecha?->format('d/m/Y'),
            $payment->numero_operacion ?? '-',
            $tipoDocumento,
            $numeroDocumento,
            $montoPEN,
            $montoUSD,
            $payment->paymentMethod?->description ?? '-',
            $payment->nota ?? '-',
            $payment->user?->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Obtener la última fila con datos
                $lastRow = $sheet->getHighestRow();
                $totalRow = $lastRow + 2;

                // Calcular totales
                $totalPEN = 0;
                $totalUSD = 0;

                // Sumar los valores de las columnas PEN (F) y USD (G)
                for ($row = 2; $row <= $lastRow; $row++) {
                    $penValue = $sheet->getCell('F' . $row)->getValue();
                    $usdValue = $sheet->getCell('G' . $row)->getValue();

                    if (is_numeric($penValue)) {
                        $totalPEN += $penValue;
                    }
                    if (is_numeric($usdValue)) {
                        $totalUSD += $usdValue;
                    }
                }

                // Escribir la fila de totales
                $sheet->setCellValue('E' . $totalRow, 'TOTAL:');
                $sheet->setCellValue('F' . $totalRow, $totalPEN);
                $sheet->setCellValue('G' . $totalRow, $totalUSD);

                // Estilo para la fila de totales
                $sheet->getStyle('E' . $totalRow . ':G' . $totalRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E2E8F0'],
                    ],
                ]);

                // Formato de número para las columnas de monto
                $sheet->getStyle('F2:F' . $lastRow)->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $sheet->getStyle('G2:G' . $lastRow)->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $sheet->getStyle('F' . $totalRow . ':G' . $totalRow)->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                // Ajustar ancho de columnas
                foreach (range('A', 'J') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}

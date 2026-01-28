<?php

namespace App\Exports;

use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CashPaymentExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $cash;

    public function __construct(Cash $cash)
    {
        $this->cash = $cash;
        $this->cash->load([
            'cashDocumentPayments.payment',
            'cashDocumentPayments.cashDocument',
            'user',
        ]);
    }

    public function collection()
    {
        $data = collect();

        // Header info
        $data->push(['REPORTE DE PAGOS - CAJA CHICA']);
        $data->push(['Nombre:', $this->cash->nombre]);
        $data->push(['Usuario:', $this->cash->user->name ?? 'N/A']);
        $data->push(['Fecha Apertura:', $this->cash->fecha_apertura?->format('d/m/Y H:i') ?? 'N/A']);
        if ($this->cash->fecha_cierre) {
            $data->push(['Fecha Cierre:', $this->cash->fecha_cierre->format('d/m/Y H:i')]);
        }
        $data->push(['Estado:', $this->cash->estado ? 'ABIERTA' : 'CERRADA']);
        $data->push(['']);

        // Pagos
        $data->push(['PAGOS REGISTRADOS']);
        $data->push(['Fecha', 'Método Pago', 'Monto', 'Referencia', 'Documento', 'Estado']);

        $totalPagos = 0;

        foreach ($this->cash->cashDocumentPayments as $docPayment) {
            $payment = $docPayment->payment;
            $document = $docPayment->cashDocument;

            if ($payment) {
                $data->push([
                    $payment->fecha_pago ? \Carbon\Carbon::parse($payment->fecha_pago)->format('d/m/Y') : 'N/A',
                    $payment->metodo_pago ?? 'Efectivo',
                    number_format($payment->monto, 2),
                    $payment->referencia ?? '-',
                    $document ? ($document->serie_numero ?? '-') : '-',
                    $payment->estado ?? 'Pagado',
                ]);

                $totalPagos += $payment->monto ?? 0;
            }
        }

        // Totales
        $data->push(['']);
        $data->push(['TOTALES']);
        $data->push(['Total Pagos:', number_format($totalPagos, 2)]);
        $data->push(['Cantidad de Pagos:', $this->cash->cashDocumentPayments->count()]);

        return $data;
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Pagos Caja';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            9 => ['font' => ['bold' => true, 'size' => 12]],
            10 => ['font' => ['bold' => true]],
        ];
    }
}

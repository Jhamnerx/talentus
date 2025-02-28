<?php

namespace App\Exports;

use App\Models\Recibos;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RecibosExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithCustomValueBinder, ShouldAutoSize, WithStyles, ShouldQueue
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 16]],
        ];
    }

    protected $estado, $fecha_fin, $fecha_inicio;

    function __construct($estado, $fecha_inicio, $fecha_fin)
    {
        $this->estado = $estado;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    public function view(): View
    {
        $recibos = Recibos::whereRaw(
            "(fecha_emision >= ? AND fecha_emision <= ?)",
            [
                $this->fecha_inicio . " 00:00:00",
                $this->fecha_fin . " 23:59:59"
            ]
        )->where('pago_estado', $this->estado)->orderBy('fecha_emision')->get();

        $total_soles = $recibos->where('divisa', 'PEN')->sum('total');
        $total_dolares = $recibos->where('divisa', 'USD')->sum('total');

        return view('exports.recibos', [
            'recibos' => $recibos,
            'total_soles' => $total_soles,
            'total_dolares' => $total_dolares,
        ]);
    }
}

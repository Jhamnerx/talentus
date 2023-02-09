<?php

namespace App\Exports;

use App\Models\Mantenimiento;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Illuminate\Contracts\View\View;

class MantenimientosExport

extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithCustomValueBinder, ShouldAutoSize, WithStyles, ShouldQueue
{
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
        return view('exports.mantenimientos', [
            'mantenimientos' => Mantenimiento::whereRaw(
                "(fecha_hora_mantenimiento >= ? AND fecha_hora_mantenimiento <= ?)",
                [
                    $this->fecha_inicio . " 00:00:00",
                    $this->fecha_fin . " 00:00:00"
                ]
            )->where('estado', $this->estado)->get()
        ]);
    }
}

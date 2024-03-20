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

    function __construct($estado, $fecha_inicio, $fecha_fin, public $cliente_id)
    {
        $this->estado = $estado;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    public function view(): View
    {
        $mantenimientos = Mantenimiento::wherehas('vehiculo', function ($vehiculo) {
            $vehiculo->whereHas('cliente', function ($cliente) {
                $cliente->where('id', $this->cliente_id);
            });
        });

        if ($this->estado !== "TODAS") {
            $mantenimientos->where('estado', $this->estado);
        }

        // ->where('estado', $this->estado)
        $mantenimientos->orderBy('estado');


        return view(
            'exports.mantenimientos',
            ['mantenimientos' => $mantenimientos->get()]
        );
    }
}

<?php

namespace App\Exports\Gerencia;

use App\Models\Clientes;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;

class ClientesExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithCustomValueBinder, ShouldAutoSize, WithStyles, ShouldQueue
{
    use Exportable;

    protected $estado;
    function __construct($estado)
    {
        $this->estado = $estado;
    }


    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 16]],
        ];
    }

    public function view(): View
    {

        $clientes = Clientes::with('vehiculos')->get();

        if ($this->estado) {

            $clientes = Clientes::with('vehiculos')->Active(true)->get();
        }

        return view('pdf.reportes.gerenciales.clientes', compact('clientes'));
    }
}

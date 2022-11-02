<?php

namespace App\Exports;

use App\Models\Clientes;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientesExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithCustomValueBinder, ShouldAutoSize
{

    use Exportable;

    public function query()
    {
        return Clientes::query();
    }

    // public function headings(): array
    // {
    //     return [
    //         '#',
    //         'RAZON SOCIAL',
    //         'DNI/RUC',
    //         'TELEFONO',
    //         'WEB-SITE',
    //         'DIRECCION',
    //         'ESTADO',
    //         'FECHA CREACION',
    //     ];
    // }

    // public function map($clientes): array
    // {
    //     return [
    //         $clientes->id,
    //         $clientes->razon_social,
    //         $clientes->numero_documento,
    //         $clientes->telefono,
    //         $clientes->web_site,
    //         $clientes->direccion,
    //         ($clientes->is_active == 1) ? 'Activo' : 'Inactivo',
    //         Carbon::createFromFormat('Y-m-d H:i:s', $clientes->created_at)->format('d-m-Y'),

    //     ];
    // }

    public function view(): View
    {
        return view('exports.clientes', [
            'clientes' => Clientes::all(),
        ]);
    }
}

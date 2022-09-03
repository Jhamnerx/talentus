<?php

namespace App\Exports;

use App\Models\Proveedores;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProveedoresExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromQuery, WithMapping, WithHeadings, WithCustomValueBinder, ShouldAutoSize
{

    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    public function query()
    {
        return Proveedores::query();
    }

    public function headings(): array
    {
        return [
            '#',
            'RAZON SOCIAL',
            'DNI/RUC',
            'TELEFONO',
            'WEB-SITE',
            'DIRECCION',
            'ESTADO',
            'FECHA CREACION',
        ];
    }


    public function map($proveedor): array
    {
        return [
            $proveedor->id,
            $proveedor->razon_social,
            $proveedor->numero_documento,
            $proveedor->telefono,
            $proveedor->web_site,
            $proveedor->direccion,
            ($proveedor->is_active == 1) ? 'Activo' : 'Inactivo',
            Carbon::createFromFormat('Y-m-d H:i:s', $proveedor->created_at)->format('d-m-Y'),

        ];
    }
}

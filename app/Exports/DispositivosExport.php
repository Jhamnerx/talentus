<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Models\Dispositivos;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DispositivosExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromQuery, WithMapping, WithHeadings, WithCustomValueBinder, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    public function query()
    {
        return Dispositivos::query();
    }
    // public function collection()
    // {
    //     return dispositivos::all();
    // }
    public function headings(): array
    {
        return [
            '#',
            'IMEI',
            'MODELO',
            'MARCA',
            'VEHICULO',
            'Registrado por:',
            'Fecha Registro',
        ];
    }

    public function map($dispositivo): array
    {
        return [
            $dispositivo->id,
            $dispositivo->imei,
            $dispositivo->modelo->modelo,
            $dispositivo->modelo->marca,
            ($dispositivo->vehiculos) ? $dispositivo->vehiculos->placa : 'Disponible',
            $dispositivo->user ? $dispositivo->user->name : '',
            Carbon::createFromFormat('Y-m-d H:i:s', $dispositivo->created_at)->format('d-m-Y'),

        ];
    }
}

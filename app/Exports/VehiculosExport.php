<?php

namespace App\Exports;

use App\Models\Vehiculos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VehiculosExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromQuery, WithMapping, WithHeadings, WithCustomValueBinder, ShouldAutoSize, ShouldQueue
{
    use Exportable, Queueable;


    public function query()
    {
        return Vehiculos::query();

    }

    public function headings(): array
    {
        return [

            '#',
            'PLACA',
            'MARCA',
            'MODELO',
            'TIPO',
            'AÑO',
            'FLOTA',
            'SIM',
            'DISPOSITIVO IMEI',
        ];
    }

    public function map($vehiculos): array
    {
        return [
            $vehiculos->id,
            $vehiculos->placa,
            $vehiculos->marca,
            $vehiculos->modelo,
            $vehiculos->tipo,
            $vehiculos->year, 
            ($vehiculos->flotas) ? $vehiculos->flotas->nombre : "",
            ($vehiculos->sim_card) ? $vehiculos->sim_card->linea->numero : "",
            ($vehiculos->dispositivos) ? $vehiculos->dispositivos->imei : "",
        ];
    }


}

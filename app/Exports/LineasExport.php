<?php

namespace App\Exports;

use App\Models\Lineas;
use App\Models\SimCard;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LineasExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromQuery, WithMapping, WithHeadings, WithCustomValueBinder, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    public function query()
    {
        return SimCard::query();
    }
    // public function collection()
    // {
    //     return Lineas::all();
    // }
    public function headings(): array
    {
        return [
            '#',
            'Sim Card',
            'Numero',

            'Operador',
            'Fecha',
        ];
    }

    public function map($sim): array
    {
        return [
            $sim->id,
            $sim->sim_card,
            ($sim->linea) ? $sim->linea->numero : '',
            $sim->operador,
            Carbon::createFromFormat('Y-m-d H:i:s', $sim->created_at)->format('d-m-Y'),

        ];
    }
}

<?php

namespace App\Exports\Gerencia;

use Carbon\Carbon;
use App\Models\Lineas;
use BaconQrCode\Renderer\Path\Line;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class LineasExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromQuery, WithMapping, WithHeadings, WithCustomValueBinder, ShouldAutoSize
{

    use Exportable;
    protected $estado;
    protected $operador;
    function __construct($estado, $operador)
    {

        $this->estado = $estado;
        $this->operador = $operador;
    }


    public function query()
    {

        if ($this->estado) {

            if ($this->operador !== "todos") {


                return Lineas::query()->whereNotNull('fecha_suspencion')->Operador($this->operador)->where('baja', false);
            } else {


                return Lineas::query()->whereNotNull('fecha_suspencion')->where('baja', false);
            }
        } else {

            if ($this->operador !== "todos") {


                return Lineas::query()->Operador($this->operador)->where('baja', false);
            } else {

                return Lineas::query()->where('baja', false);
            }
        }
    }
    // public function collection()
    // {
    //     return Lineas::all();
    // }
    public function headings(): array
    {
        return [
            '#',
            'Numero',
            'Operador',
            'Sim card',
            'Empresa Actual',
            'Placa',
            'Estado',
            'Fecha',
        ];
    }

    public function map($linea): array
    {

        return [
            $linea->id,
            $linea->numero,
            $linea->operador,
            ($linea->sim_card) ? $linea->sim_card->sim_card : '',
            ($linea->sim_card) ? ($linea->sim_card->vehiculos ? $linea->sim_card->vehiculos->cliente->razon_social : '') : '',
            ($linea->sim_card) ? ($linea->sim_card->vehiculos ? $linea->sim_card->vehiculos->placa : '') : '',
            $linea->estado->name ==  "SUSPENDIDA" ? "SUSPENDIDA: " . $linea->fecha_suspencion->format('d-m-Y') . "-" . $linea->date_to_suspend->format('d-m-Y') : $linea->estado->name,
            Carbon::createFromFormat('Y-m-d H:i:s', $linea->created_at)->format('d-m-Y'),

        ];
    }
}

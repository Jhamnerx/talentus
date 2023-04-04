<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Tareas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class TareasExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithCustomValueBinder, ShouldAutoSize, WithStyles, ShouldQueue, WithDrawings
{
    use Exportable;
    protected $tecnico_id, $fecha_inicial, $fecha_final, $estado;

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/images/logo-excel.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B1');

        return $drawing;
    }


    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 14]],
            6    => ['font' => ['bold' => true, 'size' => 14]],
            7 => ['Border' => ['allBorders' => true]]
        ];
    }

    function __construct($tecnico_id, $fecha_inicial, $fecha_final, $estado)
    {
        $this->tecnico_id = $tecnico_id;
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
        $this->estado = $estado;
    }


    public function collection()
    {
        return Tareas::all();
    }

    public function SumTotalCostTask($tareas)
    {

        $items  = collect($tareas->toArray());

        $value = $items->map(function ($item, $key) {


            $sub_total = 0;
            $sub_total =  $sub_total + $item["tipo_tarea"]["costo"];

            return number_format($sub_total, 2, '.', '');
        });

        return $value->sum();
    }

    public function view(): View
    {

        $tareas = Tareas::join('tipo_tareas', function ($join) {
            $join->on('tareas.tipo_tarea_id', '=', 'tipo_tareas.id');
        })->whereRaw(
            "(tareas.created_at >= ? AND tareas.created_at <= ?)",
            [
                $this->fecha_inicial . " 00:00:00",
                $this->fecha_final . " 23:59:59"
            ]
        )->where('tareas.tecnico_id', $this->tecnico_id)
            ->where('tareas.estado', $this->estado)
            ->with('vehiculo', 'tipo_tarea', 'user', 'tecnico', 'image')
            ->get();

        $totalCost = $this->SumTotalCostTask($tareas);

        $tecnico = User::find($this->tecnico_id);


        return view('exports.tareas', [
            'tareas' => $tareas,
            'tecnico' => $tecnico,
            'total_costo' => $totalCost,
            'fechas' => [
                'fecha_inicial' => $this->fecha_inicial,
                'fecha_final' => $this->fecha_final,
            ]
        ]);
    }

    // public function registerEvents(): array
    // {
    //     return [
    //         BeforeSheet::class => function (BeforeSheet $event) {
    //             $event->sheet
    //                 ->getPageSetup()
    //                 ->setpaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_ISO_B4)
    //                 ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //         },
    //     ];
    // }
}

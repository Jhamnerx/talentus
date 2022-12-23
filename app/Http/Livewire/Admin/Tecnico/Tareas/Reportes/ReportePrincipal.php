<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas\Reportes;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tareas;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TareasExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ReportePrincipal extends Component
{
    public $openModalReporte = false;

    public $tecnico_id, $fecha_inicial, $fecha_final, $estado = "COMPLETE";

    protected $listeners = [
        'openModalReporte' => 'openModal',
    ];


    protected  $rules = [
        'fecha_inicial' => 'required',
        'fecha_final' => 'required',
        "tecnico_id" => 'required',


    ];

    protected $messages = [
        'fecha_inicial.required' => 'La fecha es requerida',
        'fecha_final.required' => 'La fecha es requerida',
        'tecnico_id.required' => 'Selecciona un tecnico',
    ];

    public function mount()
    {
        $this->fecha_inicial = Carbon::today()->subDays(7)->format('Y-m-d');
        $this->fecha_final = Carbon::today()->addDay()->format('Y-m-d');
    }

    public function render()
    {
        $tecnicos = User::role('tecnico')->get();
        return view('livewire.admin.tecnico.tareas.reportes.reporte-principal', compact('tecnicos'));
    }

    public function openModal()
    {
        $this->openModalReporte = true;
    }

    public function exportToExcel()
    {
        $this->validate();
        return Excel::download(new TareasExport($this->tecnico_id, $this->fecha_inicial, $this->fecha_final, $this->estado), 'reporte_tareas.xlsx');
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
    public function exportToPdf()
    {
        $this->validate();

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

        $pdfContent = PDF::loadView('pdf.reportes.tareas', ['tareas' => $tareas, 'tecnico' => $tecnico, 'total_costo' => $totalCost, 'fechas' => [
            'fecha_inicial' => $this->fecha_inicial,
            'fecha_final' => $this->fecha_final,
        ]])
            ->setPaper('Legal', 'landscape')->output();

        return response()->streamDownload(
            fn () => print($pdfContent),
            "reporte_tareas.pdf"
        );

        //return Excel::download(new TareasExport($this->tecnico_id, $this->fecha_inicial, $this->fecha_final), 'reporte_tareas.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
    public function closeModal()
    {
        $this->openModalReporte = false;
    }
}

<?php

namespace App\Livewire\Admin\Gerencia\Reportes\Modales;

use App\Exports\Gerencia\LineasExport;
use App\Models\Lineas;
use App\Models\Operador;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReporteLineas extends Component
{
    public $modalReporte = false;
    public $operador = 0;
    public $suspencion = false;

    protected $listeners = [
        'openModalReporteLineas' => 'openModal',
    ];

    public function mount()
    {
        // $this->operador = Lineas::select('operador')->distinct()->first();
    }

    public function render()
    {
        $operadores = Operador::orderBy('name')->get();

        return view('livewire.admin.gerencia.reportes.modales.reporte-lineas', compact('operadores'));
    }

    public function openModal()
    {

        $this->modalReporte = true;
    }

    public function closeModal()
    {

        $this->modalReporte = false;
    }

    public function exportToPdf()
    {

        //$this->validate();

        try {
            //code...

            if ($this->suspencion) {

                $lineas = Lineas::with('sim_card', 'sim_card.vehiculos')->whereNotNull('fecha_suspencion')->where('baja', false)->get();
            } else {

                $lineas = Lineas::with('sim_card', 'sim_card.vehiculos')->where('baja', false)->get();
            }


            if ($this->operador) {

                $lineas = Lineas::where('operador_id', $this->operador)->with('sim_card')->where('baja', false)->get();
            }

            if ($this->suspencion == true && $this->operador) {

                $lineas = Lineas::where('operador_id', $this->operador)->whereNotNull('fecha_suspencion')->where('baja', false)->with('sim_card')->get();
            }



            $operadores = $this->getOperadoresCount();

            $pdfContent = PDF::loadView('pdf.reportes.gerenciales.lineas', ['lineas' => $lineas, 'operadores' => $operadores])
                ->setPaper('Legal', 'landscape')->output();

            return response()->streamDownload(
                fn() => print($pdfContent),
                "reporte_lineas.pdf"
            );
        } catch (\Throwable $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL EXPORTAR',
                mensaje: 'Ocurrio el sgte error: ' . $e->getMessage(),
            );
        }
    }

    public function exportToExcel()
    {
        try {
            return Excel::download(new LineasExport($this->suspencion, $this->operador), 'reporte_lineas.xlsx');
        } catch (\Throwable $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL EXPORTAR',
                mensaje: 'Ocurrio el sgte error: ' . $e->getMessage(),
            );
        }
    }

    public function getOperadoresCount()
    {
        $operadores =
            DB::table('lineas')
            ->join('operadores', 'lineas.operador_id', '=', 'operadores.id')
            ->select(DB::raw('COUNT(*) as count_row'), 'operadores.name as operador')
            ->whereNull('lineas.deleted_at')
            ->groupBy('operadores.id', 'operadores.name')
            ->get();

        return $operadores;
    }
}

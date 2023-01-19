<?php

namespace App\Http\Livewire\Admin\Gerencia\Reportes\Modales;

use App\Models\Lineas;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReporteLineas extends Component
{
    public $modalReporte = false;
    public $operador = "todos";
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
        $operadores = Lineas::select('operador')->distinct()->get();

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
        if ($this->suspencion) {

            $lineas = Lineas::with('sim_card', 'sim_card.vehiculos')->whereNotNull('fecha_suspencion')->get();
        } else {

            $lineas = Lineas::with('sim_card', 'sim_card.vehiculos')->get();
        }


        if ($this->operador !== "todos") {

            $lineas = Lineas::Operador($this->operador)->with('sim_card')->get();
        }

        if ($this->suspencion == true && $this->operador !== "todos") {

            $lineas = Lineas::Operador($this->operador)->whereNotNull('fecha_suspencion')->with('sim_card')->get();
        }

        //$operadores = Lineas::select('operador')->distinct()->get();

        $operadores = $this->getOperadoresCount();

        $pdfContent = PDF::loadView('pdf.reportes.gerenciales.lineas', ['lineas' => $lineas, 'operadores' => $operadores])
            ->setPaper('Legal', 'landscape')->output();

        return response()->streamDownload(
            fn () => print($pdfContent),
            "reporte_lineas.pdf"
        );
    }

    public function getOperadoresCount()
    {
        $operadores =
            DB::table("lineas")
            ->select(DB::raw("COUNT(*) as count_row, operador, created_at"))
            ->orderBy("created_at")
            ->groupBy(DB::raw("operador"))
            ->get();;

        return $operadores;
    }
}

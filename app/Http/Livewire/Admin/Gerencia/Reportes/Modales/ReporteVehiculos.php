<?php

namespace App\Http\Livewire\Admin\Gerencia\Reportes\Modales;

use Livewire\Component;
use App\Models\Vehiculos;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\VehiculosExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteVehiculos extends Component
{
    public $modalReporte = false;
    public $is_active = false;


    protected $listeners = [
        'openModalReporteVehiculos' => 'openModal',
    ];
    public function render()
    {
        return view('livewire.admin.gerencia.reportes.modales.reporte-vehiculos');
    }

    public function openModal()
    {

        $this->modalReporte = true;
    }

    public function exportToPdf()
    {


        $vehiculos = Vehiculos::get();

        if ($this->is_active) {

            $vehiculos = Vehiculos::Active(true)->get();
        }

        return Excel::download(new VehiculosExport, 'vehiculos.xls');

        // $pdfContent = PDF::loadView('pdf.reportes.gerenciales.vehiculos', ['vehiculos' => $vehiculos])
        //     ->setPaper('Legal', 'landscape')->output();

        // return response()->streamDownload(
        //     fn () => print($pdfContent),
        //     "reporte_vehiculos.pdf"
        // );
    }
}

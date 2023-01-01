<?php

namespace App\Http\Livewire\Admin\Gerencia\Reportes\Modales;

use Livewire\Component;
use App\Models\Clientes;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteClientes extends Component
{
    public $modalReporte = false;
    public $is_active = false;

    protected $listeners = [
        'openModalReporteClientes' => 'openModal',
    ];

    public function render()
    {
        return view('livewire.admin.gerencia.reportes.modales.reporte-clientes');
    }
    public function openModal()
    {

        $this->modalReporte = true;
    }

    public function exportToPdf()
    {


        $clientes = Clientes::with('vehiculos')->get();

        if ($this->is_active) {

            $clientes = Clientes::with('vehiculos')->Active(true)->get();
        }


        $pdfContent = PDF::loadView('pdf.reportes.gerenciales.clientes', ['clientes' => $clientes])
            ->setPaper('Legal', 'landscape')->output();

        return response()->streamDownload(
            fn () => print($pdfContent),
            "reporte_clientes.pdf"
        );
    }
}

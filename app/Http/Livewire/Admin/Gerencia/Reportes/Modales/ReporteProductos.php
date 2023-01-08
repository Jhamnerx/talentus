<?php

namespace App\Http\Livewire\Admin\Gerencia\Reportes\Modales;

use Livewire\Component;
use App\Models\Productos;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteProductos extends Component
{
    public $modalReporte = false;
    public $tipo = "null";

    protected $listeners = [
        'openModalReporteProductos' => 'openModal',
    ];



    public function render()
    {
        return view('livewire.admin.gerencia.reportes.modales.reporte-productos');
    }


    public function openModal()
    {

        $this->modalReporte = true;
    }


    public function exportToPdf()
    {
        //$this->validate();

        $productos = Productos::get();

        if ($this->tipo !== "null") {

            $productos = Productos::Tipo($this->tipo)->get();
        }

        $pdfContent = PDF::loadView('pdf.reportes.gerenciales.productos', ['productos' => $productos])
            ->setPaper('Legal', 'landscape')->output();

        return response()->streamDownload(
            fn () => print($pdfContent),
            "reporte_productos.pdf"
        );
    }
}

<?php

namespace App\Livewire\Admin\Reportes;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Exports\ReporteVentasRecibosExport;
use Maatwebsite\Excel\Facades\Excel;

class Ventas extends Component
{
    public $showModal = false;

    /** ventas | recibos | ambos */
    public $contexto = 'ventas';

    /** mensual | semanal - agrupacion de hojas en el Excel */
    public $agrupacion = 'mensual';

    public $tipo_comprobante_id = null;
    public $cliente_id = null;
    public $fecha_inicio;
    public $fecha_fin;
    public $estado;

    public function mount(): void
    {
        $this->fecha_inicio = Carbon::today()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin    = Carbon::today()->format('Y-m-d');
        $this->estado       = 'Todos';
    }

    #[On('open-modal-reporte-ventas')]
    public function openModalReporteVentas(): void
    {
        $this->contexto = 'ventas';
        $this->showModal = true;
    }

    #[On('openModalReporte')]
    public function openModalReporte(): void
    {
        $this->contexto = 'recibos';
        $this->showModal = true;
    }

    #[On('open-modal-reporte-ambos')]
    public function openModalReporteAmbos(): void
    {
        $this->contexto = 'ambos';
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.admin.reportes.ventas');
    }

    public function exportar()
    {
        $this->validate([
            'fecha_inicio' => 'required',
            'fecha_fin'    => 'required',
        ]);

        $nombre = 'reporte-' . $this->contexto . '-'
            . $this->fecha_inicio . '_' . $this->fecha_fin . '.xlsx';

        return Excel::download(
            new ReporteVentasRecibosExport(
                $this->contexto,
                $this->agrupacion,
                $this->fecha_inicio,
                $this->fecha_fin,
                $this->estado,
                $this->tipo_comprobante_id,
                $this->cliente_id,
            ),
            $nombre
        );
    }
}

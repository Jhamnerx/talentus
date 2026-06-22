<?php

namespace App\Livewire\Admin\Reportes;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Exports\ReporteDetallesItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class DetallesItems extends Component
{
    public $showModal = false;

    /** ventas | recibos */
    public $contexto = 'ventas';

    public $fecha_inicio;
    public $fecha_fin;

    /** todos | producto | servicio */
    public $tipo_item = 'todos';

    /** todos | COMPLETADO | BORRADOR | anulado */
    public $estado_doc = 'todos';

    public $cliente_id = null;
    public $tipo_comprobante_id = null;

    public function mount(): void
    {
        $this->fecha_inicio = Carbon::today()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin    = Carbon::today()->format('Y-m-d');
    }

    #[On('open-modal-reporte-detalles-ventas')]
    public function openModalVentas(): void
    {
        $this->contexto = 'ventas';
        $this->showModal = true;
    }

    #[On('open-modal-reporte-detalles-recibos')]
    public function openModalRecibos(): void
    {
        $this->contexto = 'recibos';
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.admin.reportes.detalles-items');
    }

    public function exportar()
    {
        $this->validate([
            'fecha_inicio' => 'required',
            'fecha_fin'    => 'required',
        ]);

        $nombre = 'reporte-detalles-' . $this->contexto . '-'
            . $this->fecha_inicio . '_' . $this->fecha_fin . '.xlsx';

        return Excel::download(
            new ReporteDetallesItemsExport(
                $this->contexto,
                $this->fecha_inicio,
                $this->fecha_fin,
                $this->tipo_item,
                $this->estado_doc,
                $this->cliente_id,
                $this->tipo_comprobante_id,
            ),
            $nombre
        );
    }
}

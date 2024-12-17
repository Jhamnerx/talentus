<?php

namespace App\Livewire\Admin\Reportes;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Exports\VentasExportSimple;
use Maatwebsite\Excel\Facades\Excel;

class Ventas extends Component
{

    public $showModal = false;
    public $tipo_comprobante_id = null, $cliente_id, $vendedor_id;
    public $fecha_inicio, $fecha_fin, $estado;

    public function mount()
    {
        // Obtén una instancia de Carbon solo una vez
        $carbon = Carbon::today(); // Esto asegura que estamos trabajando con la fecha actual sin considerar la hora

        // Define las fechas
        $this->fecha_inicio = $carbon->copy()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin = $carbon->format('Y-m-d');
        $this->estado = 'Todos';
    }

    public function render()
    {
        return view('livewire.admin.reportes.ventas');
    }

    #[On('open-modal-reporte-ventas')]
    public function openModalReporteVentas()
    {
        $this->showModal = true;
    }

    public function updatedFechaInicio($value)
    {
        //dd('Fecha Inicio Updated:', $value);
    }

    public function exportar()
    {
        $this->validate([
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',

        ]);

        $nombre = 'reporte_ventas-' . $this->fecha_inicio . '_' . $this->fecha_fin . '.xls';

        return Excel::download(new VentasExportSimple($this->fecha_inicio, $this->fecha_fin, $this->estado, $this->tipo_comprobante_id, $this->cliente_id, $this->vendedor_id), $nombre);
    }
}

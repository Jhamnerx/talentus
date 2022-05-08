<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use App\Models\Reportes;
use Livewire\Component;

class ReportesIndex extends Component
{
    public $search;
    public $from = '';
    public $to = '';

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $reportes = Reportes::whereHas('vehiculos', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%')
                ->orWhere('marca', 'like', '%' . $this->search . '%')
                ->orWhere('tipo', 'like', '%' . $this->search . '%')
                ->orwhereHas('flotas', function ($query) {
                    $query->where('nombre', 'like', '%' . $this->search . '%');
                });
        })->orWhere('fecha_t', 'like', '%' . $this->search . '%')
            ->orWhere('hora_t', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orWhere('detalle', 'like', '%' . $this->search . '%')
            ->orderBy('id')
            ->paginate(10);




        $total = Reportes::all()->count();


        if (!empty($desde)) {


            $reportes = Reportes::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(placa like ? OR fecha_t like  ? OR hora_t like ? OR detalle like ?)",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('id')
                ->paginate(10);
        }
        return view('livewire.admin.vehiculos.reportes-index', compact('reportes', 'total'));
    }
    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 7 days"));
                $this->to = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 month"));
                $this->to = date('Y-m-d');
                break;
            case '12':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 year"));
                $this->to = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }
}

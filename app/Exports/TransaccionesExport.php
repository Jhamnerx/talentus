<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

class TransaccionesExport implements FromView, ShouldAutoSize, WithTitle
{
    use Exportable;

    protected $movimientos;
    protected $totales;
    protected $filters;
    protected $company;

    public function __construct($movimientos, $totales, $filters)
    {
        $this->movimientos = $movimientos;
        $this->totales = $totales;
        $this->filters = $filters;
    }

    public function title(): string
    {
        return substr('Transacciones', 0, 30);
    }

    public function view(): View
    {
        $this->company = \App\Models\Empresa::find(session('empresa'));

        $periodDescription = $this->buildPeriodDescription();

        return view('exports.transacciones', [
            'movimientos' => $this->movimientos,
            'totales' => $this->totales,
            'company' => $this->company,
            'period' => $periodDescription,
            'filters' => $this->filters,
        ]);
    }

    private function buildPeriodDescription()
    {
        $periodType = $this->filters['period_type'] ?? 'date_range';

        switch ($periodType) {
            case 'month':
                if (!empty($this->filters['month'])) {
                    $date = Carbon::parse($this->filters['month'] . '-01');
                    return 'Mes: ' . ucfirst($date->isoFormat('MMMM YYYY'));
                }
                break;

            case 'month_range':
                if (!empty($this->filters['month_start']) && !empty($this->filters['month_end'])) {
                    $dateStart = Carbon::parse($this->filters['month_start'] . '-01');
                    $dateEnd = Carbon::parse($this->filters['month_end'] . '-01');
                    return 'Desde ' . ucfirst($dateStart->isoFormat('MMMM YYYY')) .
                        ' hasta ' . ucfirst($dateEnd->isoFormat('MMMM YYYY'));
                }
                break;

            case 'date':
                if (!empty($this->filters['from'])) {
                    $date = Carbon::parse($this->filters['from']);
                    return 'Fecha: ' . $date->format('d/m/Y');
                }
                break;

            case 'date_range':
                if (!empty($this->filters['from']) && !empty($this->filters['to'])) {
                    $from = Carbon::parse($this->filters['from']);
                    $to = Carbon::parse($this->filters['to']);
                    return 'Desde ' . $from->format('d/m/Y') . ' hasta ' . $to->format('d/m/Y');
                }
                break;
        }

        return 'Todos los periodos';
    }
}

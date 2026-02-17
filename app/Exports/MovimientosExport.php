<?php

namespace App\Exports;

use App\Models\GlobalPayment;
use App\Models\Cash;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class MovimientosExport implements FromView, ShouldAutoSize, WithTitle
{
    use Exportable;

    protected $movements;
    protected $totales;
    protected $filters;
    protected $periodDescription;

    public function __construct($movements, $totales, $filters = [])
    {
        $this->movements = $movements;
        $this->totales = $totales;
        $this->filters = $filters;
        $this->buildPeriodDescription();
    }

    protected function buildPeriodDescription()
    {
        $periodType = $this->filters['period_type'] ?? 'month';
        $from = $this->filters['from'] ?? '';
        $to = $this->filters['to'] ?? '';

        switch ($periodType) {
            case 'month':
                $month = $this->filters['month'] ?? now()->format('Y-m');
                $this->periodDescription = "Mes: " . \Carbon\Carbon::parse($month . '-01')->locale('es')->isoFormat('MMMM YYYY');
                break;
            case 'month_range':
                $monthStart = $this->filters['month_start'] ?? '';
                $monthEnd = $this->filters['month_end'] ?? '';
                $this->periodDescription = "Entre: " .
                    \Carbon\Carbon::parse($monthStart . '-01')->locale('es')->isoFormat('MMM YYYY') .
                    " - " .
                    \Carbon\Carbon::parse($monthEnd . '-01')->locale('es')->isoFormat('MMM YYYY');
                break;
            case 'date':
                $this->periodDescription = "Fecha: " . \Carbon\Carbon::parse($from)->format('d/m/Y');
                break;
            case 'date_range':
                $this->periodDescription = "Entre: " .
                    \Carbon\Carbon::parse($from)->format('d/m/Y') .
                    " - " .
                    \Carbon\Carbon::parse($to)->format('d/m/Y');
                break;
        }
    }

    public function title(): string
    {
        return substr('Movimientos', 0, 30);
    }

    public function view(): View
    {
        $company = \App\Models\Empresa::find(session('empresa'));

        return view('exports.movimientos', [
            'movements' => $this->movements,
            'totales' => $this->totales,
            'company' => $company,
            'filters' => $this->filters,
            'periodDescription' => $this->periodDescription,
        ]);
    }
}

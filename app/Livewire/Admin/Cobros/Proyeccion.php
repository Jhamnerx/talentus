<?php

namespace App\Livewire\Admin\Cobros;

use App\Enums\CobroEstado;
use App\Models\PeriodoCobro;
use Carbon\Carbon;
use Livewire\Component;

class Proyeccion extends Component
{
    public ?string $fechaDesde   = null;
    public ?string $fechaHasta   = null;
    public string  $tipoPago     = '';
    public string  $agruparPor   = 'dia';

    public function mount(): void
    {
        $this->fechaDesde = Carbon::today()->format('Y-m-d');
        $this->fechaHasta = Carbon::today()->addDays(7)->format('Y-m-d');
    }

    public function updatedFechaDesde(): void
    {
        if (!$this->fechaDesde) {
            $this->fechaDesde = Carbon::today()->format('Y-m-d');
            return;
        }
        if ($this->fechaHasta && $this->fechaHasta < $this->fechaDesde) {
            $this->fechaHasta = $this->fechaDesde;
        }
    }

    public function updatedFechaHasta(): void
    {
        if (!$this->fechaHasta) {
            $this->fechaHasta = $this->fechaDesde ?? Carbon::today()->format('Y-m-d');
        }
    }

    /**
     * Periodos PENDIENTES de cobros ACTIVOS dentro del rango seleccionado,
     * opcionalmente filtrados por tipo_pago del cobro padre.
     *
     * @return \Illuminate\Support\Collection<string, \Illuminate\Support\Collection>
     */
    private function periodosFiltrados()
    {
        $desde = Carbon::parse($this->fechaDesde ?? Carbon::today())->startOfDay();
        $hasta = Carbon::parse($this->fechaHasta ?? Carbon::today()->addDays(7))->endOfDay();
        $tipo  = $this->tipoPago;

        return PeriodoCobro::query()
            ->where('estado', 'PENDIENTE')
            ->whereHas('cobro', function ($q) use ($tipo) {
                $q->where('estado', CobroEstado::ACTIVO);
                if ($tipo !== '') {
                    $q->where('tipo_pago', $tipo);
                }
            })
            ->whereBetween('fecha_fin', [$desde, $hasta])
            ->with([
                'cobro.clientes',
                'cobro.plan',
                'vehiculo',
            ])
            ->orderBy('fecha_fin')
            ->get();
    }

    public function render()
    {
        $periodos = $this->periodosFiltrados();

        // Agrupar por día o por semana
        $agrupados = $periodos->groupBy(function (PeriodoCobro $p) {
            if ($this->agruparPor === 'semana') {
                $inicio = Carbon::parse($p->fecha_fin)->startOfWeek();
                $fin    = Carbon::parse($p->fecha_fin)->endOfWeek();
                return $inicio->format('Y-m-d') . '|' . $fin->format('Y-m-d');
            }
            return $p->fecha_fin->format('Y-m-d');
        });

        // Resumen totales por divisa
        $totalPen = $periodos->filter(fn($p) => $p->cobro?->divisa === 'PEN')->sum('monto');
        $totalUsd = $periodos->filter(fn($p) => $p->cobro?->divisa === 'USD')->sum('monto');

        return view('livewire.admin.cobros.proyeccion', [
            'agrupados'  => $agrupados,
            'totalPen'   => $totalPen,
            'totalUsd'   => $totalUsd,
            'totalItems' => $periodos->count(),
        ]);
    }
}

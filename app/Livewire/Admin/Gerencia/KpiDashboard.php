<?php

namespace App\Livewire\Admin\Gerencia;

use Carbon\Carbon;
use App\Models\Kpi;
use App\Models\KpiResultado;
use App\Services\KpiCalculatorService;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Lazy]
#[Layout('layouts.admin')]
class KpiDashboard extends Component
{
    // Período del semáforo
    public string $periodo = 'semana'; // semana | mes
    public ?string $fechaInicio = null;
    public ?string $fechaFin = null;

    // Datos calculados
    public array $wigs = [];
    public array $kpisPorArea = [];
    public array $scoreboardRows = [];
    public array $resumenAreas = [];

    // Modal edición manual
    public bool $modalManual = false;
    public ?int $kpiIdEditar = null;
    public string $kpiNombreEditar = '';
    public float $valorManual = 0;
    public string $notasManual = '';

    protected KpiCalculatorService $calculador;

    public function boot(KpiCalculatorService $calculador): void
    {
        $this->calculador = $calculador;
    }

    public function mount(): void
    {
        $this->setPeriodo('semana');
    }

    public function setPeriodo(string $periodo): void
    {
        $this->periodo = $periodo;

        if ($periodo === 'semana') {
            $this->fechaInicio = now()->startOfWeek(Carbon::MONDAY)->toDateString();
            $this->fechaFin    = now()->endOfWeek(Carbon::SUNDAY)->toDateString();
        } else {
            $this->fechaInicio = now()->startOfMonth()->toDateString();
            $this->fechaFin    = now()->endOfMonth()->toDateString();
        }

        $this->calcular();
    }

    public function calcular(): void
    {
        $inicio = Carbon::parse($this->fechaInicio);
        $fin    = Carbon::parse($this->fechaFin);

        $this->calculador->inicio = $inicio;
        $this->calculador->fin    = $fin;

        // WIGs
        $this->wigs = $this->calculador->calcularWigs();

        // KPIs
        $resultados = $this->calculador->calcularTodos($inicio, $fin);
        $this->construirDashboard($resultados);
    }

    private function construirDashboard(array $resultados): void
    {
        $this->kpisPorArea   = [];
        $this->scoreboardRows = [];
        $this->resumenAreas  = [];

        $areas = [
            'comercial'      => ['nombre' => 'Comercial',       'responsable' => 'Jacky',          'color' => 'blue'],
            'operaciones'    => ['nombre' => 'Operaciones',     'responsable' => 'Rolando / José',  'color' => 'orange'],
            'administracion' => ['nombre' => 'Administración',  'responsable' => 'Sandra / Jesi',   'color' => 'purple'],
            'postventa'      => ['nombre' => 'Postventa',       'responsable' => 'Jacky',           'color' => 'teal'],
            'monitoreo'      => ['nombre' => 'Monitoreo GPS',   'responsable' => 'José / Rolando',  'color' => 'indigo'],
            'gerencia'       => ['nombre' => 'Gerencia',        'responsable' => 'Jhovana',         'color' => 'rose'],
        ];

        // Inicializar áreas
        foreach ($areas as $areaKey => $areaData) {
            $this->kpisPorArea[$areaKey] = array_merge($areaData, ['kpis' => [], 'semaforo' => 'verde']);
        }

        // Distribuir resultados
        foreach ($resultados as $slug => $resultado) {
            $area = $resultado['area'] ?? null;
            if (!$area || !isset($this->kpisPorArea[$area])) {
                continue;
            }
            $this->kpisPorArea[$area]['kpis'][] = $resultado;
            $this->scoreboardRows[] = array_merge($resultado, [
                'area_nombre' => $areas[$area]['nombre'] ?? $area,
                'color'       => $areas[$area]['color'] ?? 'gray',
            ]);
        }

        // Calcular semáforo de área (el peor de sus KPIs)
        foreach ($this->kpisPorArea as $areaKey => &$areaData) {
            $semaforos = array_column($areaData['kpis'], 'semaforo');
            if (in_array('rojo', $semaforos)) {
                $areaData['semaforo'] = 'rojo';
            } elseif (in_array('amarillo', $semaforos)) {
                $areaData['semaforo'] = 'amarillo';
            } else {
                $areaData['semaforo'] = 'verde';
            }

            // Cumplimiento promedio del área
            $cumplimientos = array_column($areaData['kpis'], 'cumplimiento');
            $areaData['cumplimiento_promedio'] = count($cumplimientos)
                ? round(array_sum($cumplimientos) / count($cumplimientos), 1)
                : 0;

            $this->resumenAreas[] = [
                'area'         => $areaKey,
                'nombre'       => $areaData['nombre'],
                'responsable'  => $areaData['responsable'],
                'semaforo'     => $areaData['semaforo'],
                'cumplimiento' => $areaData['cumplimiento_promedio'],
                'color'        => $areaData['color'],
            ];
        }
    }

    // =============================
    // EDICIÓN MANUAL DE KPI
    // =============================

    public function abrirModalManual(int $kpiId): void
    {
        $kpi = Kpi::find($kpiId);
        if (!$kpi || $kpi->tipo !== 'manual') {
            return;
        }

        $this->kpiIdEditar    = $kpiId;
        $this->kpiNombreEditar = $kpi->nombre;
        $this->valorManual    = 0;
        $this->notasManual    = '';

        // Cargar último valor registrado
        $ultimo = KpiResultado::where('kpi_id', $kpiId)
            ->orderByDesc('periodo_inicio')
            ->first();

        if ($ultimo) {
            $this->valorManual = (float) $ultimo->valor_actual;
            $this->notasManual = $ultimo->notas ?? '';
        }

        $this->modalManual = true;
    }

    public function guardarManual(): void
    {
        $this->validate([
            'valorManual' => 'required|numeric|min:0|max:9999999',
            'notasManual' => 'nullable|string|max:500',
        ]);

        $kpi = Kpi::find($this->kpiIdEditar);
        if (!$kpi) {
            return;
        }

        $inicio = Carbon::parse($this->fechaInicio);
        $fin    = Carbon::parse($this->fechaFin);

        $meta   = (float) $kpi->meta;
        $valor  = $this->valorManual;

        // Calcular cumplimiento y semáforo
        if ($meta > 0) {
            $cumplimiento = round(($valor / $meta) * 100, 1);
        } else {
            // Para KPIs de meta 0 (menos es mejor)
            $cumplimiento = $valor === 0.0 ? 100 : 0;
        }

        $metaMinima = $kpi->meta_minima ?? ($meta * 0.8);
        if ($meta > 0) {
            $semaforo = $valor >= $meta ? 'verde' : ($valor >= $metaMinima ? 'amarillo' : 'rojo');
        } else {
            $semaforo = $valor === 0.0 ? 'verde' : ($valor <= 2 ? 'amarillo' : 'rojo');
        }

        KpiResultado::updateOrCreate(
            [
                'kpi_id'         => $kpi->id,
                'empresa_id'     => (int) session('empresa'),
                'periodo_inicio' => $inicio->toDateString(),
                'periodo_fin'    => $fin->toDateString(),
            ],
            [
                'valor_actual'   => $valor,
                'valor_meta'     => $meta,
                'cumplimiento'   => $cumplimiento,
                'semaforo'       => $semaforo,
                'notas'          => $this->notasManual,
                'registrado_por' => \Illuminate\Support\Facades\Auth::id(),
                'calculado_at'   => now(),
            ]
        );

        $this->modalManual = false;
        $this->calcular();

        $this->dispatch('notify', [
            'title'       => 'KPI actualizado',
            'description' => "Valor de «{$kpi->nombre}» guardado correctamente.",
            'icon'        => 'success',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.gerencia.kpi-dashboard');
    }
}

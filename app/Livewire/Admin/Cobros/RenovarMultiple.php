<?php

namespace App\Livewire\Admin\Cobros;

use App\Enums\CobroEstado;
use App\Models\Clientes;
use App\Models\Cobros;
use App\Models\PeriodoCobro;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class RenovarMultiple extends Component
{
    use WireUiActions;

    public bool $modalOpen = false;

    public array  $cobroIds    = [];
    public string $fechaInicio = '';
    public string $fechaFin    = '';
    public string $periodo     = 'MENSUAL';
    public string $divisa      = 'PEN';
    public float  $descuento   = 0;
    public string $observaciones = '';
    public bool   $cobrarAhora = false;

    /** Resumen para mostrar en el modal */
    public string $clienteNombre  = '';
    public int    $totalVehiculos = 0;
    public array  $vehiculosInfo  = [];

    protected $listeners = [
        'abrirRenovarMultiple' => 'abrir',
    ];

    protected function rules(): array
    {
        return [
            'fechaInicio'   => 'required|date',
            'fechaFin'      => 'required|date|after:fechaInicio',
            'descuento'     => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string|max:500',
        ];
    }

    public function abrir(array $cobroIds): void
    {
        $cobros = Cobros::withoutGlobalScopes()
            ->with(['vehiculo', 'clientes'])
            ->whereIn('id', $cobroIds)
            ->get();

        if ($cobros->isEmpty()) {
            return;
        }

        $this->cobroIds       = $cobroIds;
        $this->periodo        = $cobros->first()->periodo ?? 'MENSUAL';
        $this->divisa         = $cobros->first()->divisa ?? 'PEN';
        $this->clienteNombre  = $cobros->first()->clientes?->razon_social ?? '—';
        $this->totalVehiculos = $cobros->count();
        $this->descuento      = 0;
        $this->observaciones  = '';
        $this->cobrarAhora    = false;

        // fechaInicio = día siguiente al máximo vencimiento entre todos los cobros
        $maxVencimiento = $cobros
            ->filter(fn($c) => $c->fecha_vencimiento !== null)
            ->max(fn($c) => $c->fecha_vencimiento);

        $nuevaFechaInicio = $maxVencimiento
            ? Carbon::parse($maxVencimiento)->addDay()->format('Y-m-d')
            : Carbon::today()->format('Y-m-d');

        $this->fechaInicio = $nuevaFechaInicio;
        $this->fechaFin    = $this->calcularFechaFin($nuevaFechaInicio, $this->periodo);

        // Resumen de vehículos
        $this->vehiculosInfo = $cobros->map(fn($c) => [
            'placa' => $c->vehiculo?->placa ?? "ID:{$c->id}",
            'monto' => $c->monto ?? 0,
        ])->toArray();

        $this->modalOpen = true;
    }

    public function updatedFechaInicio(): void
    {
        if ($this->fechaInicio) {
            $this->fechaFin = $this->calcularFechaFin($this->fechaInicio, $this->periodo);
        }
    }

    public function updatedPeriodo(): void
    {
        if ($this->fechaInicio) {
            $this->fechaFin = $this->calcularFechaFin($this->fechaInicio, $this->periodo);
        }
    }

    protected function calcularFechaFin(string $fechaInicio, string $periodo): string
    {
        return match ($periodo) {
            'MENSUAL'    => Carbon::parse($fechaInicio)->addMonthNoOverflow()->subDay()->format('Y-m-d'),
            'BIMENSUAL'  => Carbon::parse($fechaInicio)->addMonthsNoOverflow(2)->subDay()->format('Y-m-d'),
            'TRIMESTRAL' => Carbon::parse($fechaInicio)->addMonthsNoOverflow(3)->subDay()->format('Y-m-d'),
            'SEMESTRAL'  => Carbon::parse($fechaInicio)->addMonthsNoOverflow(6)->subDay()->format('Y-m-d'),
            'ANUAL'      => Carbon::parse($fechaInicio)->addYearNoOverflow()->subDay()->format('Y-m-d'),
            default      => Carbon::parse($fechaInicio)->addMonthNoOverflow()->subDay()->format('Y-m-d'),
        };
    }

    public function renovar(): void
    {
        $this->validate();

        try {
            $cobros         = Cobros::withoutGlobalScopes()->whereIn('id', $this->cobroIds)->get();
            $periodosCreados = [];

            foreach ($cobros as $cobro) {
                $montoFinal = max(0, ($cobro->monto ?? 0) - ($this->descuento ?? 0));

                $periodo = PeriodoCobro::create([
                    'cobros_id'     => $cobro->id,
                    'cliente_id'    => $cobro->clientes_id,
                    'vehiculo_id'   => $cobro->vehiculos_id,
                    'fecha_inicio'  => $this->fechaInicio,
                    'fecha_fin'     => $this->fechaFin,
                    'periodo'       => $this->periodo,
                    'monto'         => $montoFinal,
                    'divisa'        => $this->divisa,
                    'tipo'          => 'RENOVACION',
                    'estado'        => 'PENDIENTE',
                    'observaciones' => $this->observaciones ?: null,
                ]);

                $cobro->update([
                    'fecha_inicio'      => $this->fechaInicio,
                    'fecha_vencimiento' => $this->fechaFin,
                    'periodo'           => $this->periodo,
                    'estado'            => CobroEstado::ACTIVO,
                ]);

                $periodosCreados[] = $periodo->id;
            }

            $this->modalOpen = false;
            $this->dispatch('render');

            if ($this->cobrarAhora && !empty($periodosCreados)) {
                $primerCobro    = $cobros->first();
                $tipo           = $primerCobro->tipo_pago ?? 'FACTURA';
                $cliente        = $primerCobro->clientes;
                $periodoIdsJson = json_encode($periodosCreados);

                if ($tipo === 'RECIBO') {
                    $this->redirect(
                        route('admin.ventas.recibos.create', ['periodo_ids' => $periodoIdsJson]),
                        navigate: true
                    );
                    return;
                }

                if (($cliente?->tipo_documento_id ?? null) == 6) {
                    $this->redirect(
                        route('admin.factura.create', ['periodo_ids' => $periodoIdsJson]),
                        navigate: true
                    );
                    return;
                }

                $this->redirect(
                    route('admin.boleta.create', ['periodo_ids' => $periodoIdsJson]),
                    navigate: true
                );
                return;
            }

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'RENOVACIÓN MASIVA',
                mensaje: count($periodosCreados) . ' período(s) renovados correctamente',
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL RENOVAR',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function cerrar(): void
    {
        $this->modalOpen      = false;

        $this->vehiculosInfo  = [];
    }

    public function render()
    {
        return view('livewire.admin.cobros.renovar-multiple');
    }
}

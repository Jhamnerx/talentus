<?php

namespace App\Livewire\Admin\Cobros;

use App\Enums\CobroEstado;
use App\Models\Cobros;
use App\Models\PeriodoCobro;
use App\Models\Plan;
use App\Models\Vehiculos;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class RegistrarFlota extends Component
{
    use WireUiActions;

    public bool $modalOpen = false;

    public ?int    $cliente_id       = null;
    public array   $vehiculo_ids     = [];
    public ?int    $plan_id          = null;
    public string  $periodo          = 'MENSUAL';
    public string  $divisa           = 'PEN';
    public string  $tipo_comprobante = 'FACTURA';
    public string  $fecha_inicio     = '';
    public string  $fecha_fin        = '';
    public float   $monto            = 0;
    public float   $descuento        = 0;
    public ?string $nota             = null;

    public Collection $planes;
    public Collection $vehiculos;

    protected function rules(): array
    {
        return [
            'cliente_id'       => 'required|exists:clientes,id',
            'vehiculo_ids'     => 'required|array|min:1',
            'vehiculo_ids.*'   => 'exists:vehiculos,id',
            'plan_id'          => 'required|exists:plans,id',
            'periodo'          => 'required|in:MENSUAL,BIMENSUAL,TRIMESTRAL,SEMESTRAL,ANUAL',
            'divisa'           => 'required|in:PEN,USD',
            'tipo_comprobante' => 'required|in:FACTURA,RECIBO',
            'fecha_inicio'     => 'required|date',
            'fecha_fin'        => 'required|date|after:fecha_inicio',
            'monto'            => 'required|numeric|min:0',
            'descuento'        => 'nullable|numeric|min:0',
            'nota'             => 'nullable|string|max:1000',
        ];
    }

    protected $listeners = [
        'abrirRegistrarFlota' => 'abrir',
    ];

    public function mount(): void
    {
        $this->planes   = collect();
        $this->vehiculos = collect();
        $this->loadPlanes();
        $this->fecha_inicio = Carbon::today()->format('Y-m-d');
        $this->fecha_fin    = Carbon::today()->addMonthNoOverflow()->format('Y-m-d');
    }

    private function loadPlanes(): void
    {
        $this->planes = Plan::where('is_active', true)->orderBy('sort_order')->get();
    }

    public function abrir(): void
    {
        $this->loadPlanes();
        $this->reset(['cliente_id', 'vehiculo_ids', 'plan_id', 'monto', 'descuento', 'nota']);
        $this->vehiculos        = collect();
        $this->periodo          = 'MENSUAL';
        $this->divisa           = 'PEN';
        $this->tipo_comprobante = 'FACTURA';
        $this->fecha_inicio     = Carbon::today()->format('Y-m-d');
        $this->fecha_fin        = Carbon::today()->addMonthNoOverflow()->format('Y-m-d');
        $this->modalOpen        = true;
    }

    public function updatedClienteId(): void
    {
        $this->vehiculo_ids = [];

        if ($this->cliente_id) {
            $this->vehiculos = Vehiculos::where('clientes_id', $this->cliente_id)
                ->orderBy('placa')
                ->get(['id', 'placa', 'marca', 'modelo']);
        } else {
            $this->vehiculos = collect();
        }
    }

    public function updatedPlanId(): void
    {
        $this->monto = $this->calcularMonto();
    }

    public function updatedPeriodo(): void
    {
        if ($this->fecha_inicio) {
            $this->fecha_fin = $this->calcularFechaFin($this->fecha_inicio, $this->periodo);
        }
        $this->monto = $this->calcularMonto();
    }

    public function updatedFechaInicio(): void
    {
        if ($this->fecha_inicio) {
            $this->fecha_fin = $this->calcularFechaFin($this->fecha_inicio, $this->periodo);
        }
    }

    public function updatedDivisa(): void
    {
        $this->monto = $this->calcularMonto();
    }

    public function updatedTipoComprobante(): void
    {
        $this->monto = $this->calcularMonto();
    }

    protected function calcularMonto(): float
    {
        $plan = $this->plan_id ? Plan::find($this->plan_id) : null;
        if (!$plan) {
            return 0;
        }

        $multiplicador = match ($this->periodo) {
            'BIMENSUAL'  => 2,
            'TRIMESTRAL' => 3,
            'SEMESTRAL'  => 6,
            'ANUAL'      => 12,
            default      => 1,
        };

        $precio       = (float) $plan->price;
        $planCurrency = $plan->currency ?? 'PEN';

        if ($planCurrency !== $this->divisa) {
            $tc = tipo_cambio()
                ?? tipo_cambio(now()->subDay()->format('Y-m-d'))
                ?? tipo_cambio(now()->subDays(2)->format('Y-m-d'))
                ?? 1;
            if ($planCurrency === 'PEN' && $this->divisa === 'USD') {
                $precio = round($precio / $tc, 4);
            } elseif ($planCurrency === 'USD' && $this->divisa === 'PEN') {
                $precio = round($precio * $tc, 4);
            }
        }

        $monto = $precio * $multiplicador;

        if ($this->tipo_comprobante !== 'RECIBO') {
            $monto = $monto * 1.18;
        }

        return round($monto, 4);
    }

    protected function calcularFechaFin(string $fechaInicio, string $periodo): string
    {
        return match ($periodo) {
            'MENSUAL'    => Carbon::parse($fechaInicio)->addMonthNoOverflow()->format('Y-m-d'),
            'BIMENSUAL'  => Carbon::parse($fechaInicio)->addMonthsNoOverflow(2)->format('Y-m-d'),
            'TRIMESTRAL' => Carbon::parse($fechaInicio)->addMonthsNoOverflow(3)->format('Y-m-d'),
            'SEMESTRAL'  => Carbon::parse($fechaInicio)->addMonthsNoOverflow(6)->format('Y-m-d'),
            'ANUAL'      => Carbon::parse($fechaInicio)->addYearNoOverflow()->format('Y-m-d'),
            default      => Carbon::parse($fechaInicio)->addMonthNoOverflow()->format('Y-m-d'),
        };
    }

    public function guardar(): void
    {
        $this->validate();

        try {
            $montoFinal = max(0, round($this->monto - ($this->descuento ?? 0), 4));
            $creados    = 0;
            $omitidos   = [];

            foreach ($this->vehiculo_ids as $vehiculoId) {
                // Omitir si ya tiene un cobro activo o suspendido
                $existe = Cobros::where('vehiculos_id', $vehiculoId)
                    ->whereIn('estado', [CobroEstado::ACTIVO, CobroEstado::SUSPENDIDO])
                    ->exists();

                if ($existe) {
                    $vehiculo   = Vehiculos::find($vehiculoId);
                    $omitidos[] = $vehiculo?->placa ?? "ID:{$vehiculoId}";
                    continue;
                }

                $cobro = Cobros::create([
                    'clientes_id'       => $this->cliente_id,
                    'vehiculos_id'      => $vehiculoId,
                    'plan_id'           => $this->plan_id,
                    'periodo'           => $this->periodo,
                    'divisa'            => $this->divisa,
                    'tipo_pago'         => $this->tipo_comprobante,
                    'fecha_inicio'      => $this->fecha_inicio,
                    'fecha_vencimiento' => $this->fecha_fin,
                    'monto'             => $montoFinal,
                    'descuento'         => $this->descuento ?? 0,
                    'nota'              => $this->nota,
                    'estado'            => CobroEstado::ACTIVO,
                ]);

                PeriodoCobro::create([
                    'cobros_id'     => $cobro->id,
                    'cliente_id'    => $this->cliente_id,
                    'vehiculo_id'   => $vehiculoId,
                    'fecha_inicio'  => $this->fecha_inicio,
                    'fecha_fin'     => $this->fecha_fin,
                    'periodo'       => $this->periodo,
                    'monto'         => $montoFinal,
                    'divisa'        => $this->divisa,
                    'tipo'          => 'INICIAL',
                    'estado'        => 'PENDIENTE',
                    'observaciones' => $this->nota,
                ]);

                $creados++;
            }

            $this->modalOpen = false;
            $this->dispatch('render');

            $mensaje = "Se registraron {$creados} vehículo(s) correctamente.";
            if (!empty($omitidos)) {
                $mensaje .= ' Omitidos por cobro existente: ' . implode(', ', $omitidos) . '.';
            }

            $this->dispatch(
                'notify-toast',
                icon: empty($omitidos) ? 'success' : 'warning',
                title: 'FLOTA REGISTRADA',
                mensaje: $mensaje,
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function cerrar(): void
    {
        $this->modalOpen = false;
        $this->reset(['cliente_id', 'vehiculo_ids', 'plan_id', 'monto', 'descuento', 'nota']);
        $this->vehiculos = collect();
    }

    public function render()
    {
        return view('livewire.admin.cobros.registrar-flota');
    }
}

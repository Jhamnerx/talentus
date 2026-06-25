<?php

namespace App\Livewire\Admin\Cobros;

use App\Enums\CobroEstado;
use App\Models\Clientes;
use App\Models\Cobros;
use App\Models\PeriodoCobro;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class RegistrarCobro extends Component
{
    use WireUiActions;

    public bool $modalOpen = false;
    public ?int $cobroId = null;

    // Campos del registro
    public ?int $cliente_id         = null;
    public ?int $vehiculo_id        = null;
    public ?int $plan_id            = null;
    public string $periodo          = 'MENSUAL';
    public string $divisa           = 'PEN';
    public string $tipo_comprobante = 'FACTURA';
    public string $fecha_inicio     = '';
    public string $fecha_fin        = '';
    public float $monto             = 0;
    public float $descuento         = 0;
    public ?string $nota            = null;
    public bool $cobrar_ahora       = false;

    public Collection $planes;

    protected function rules(): array
    {
        return [
            'cliente_id'       => 'required|exists:clientes,id',
            'vehiculo_id'      => 'required|exists:vehiculos,id',
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
        'abrirRegistrarCobro' => 'abrir',
    ];

    public function mount(): void
    {
        $this->planes = collect();
        $this->loadPlanes();
        $this->fecha_inicio = Carbon::today()->format('Y-m-d');
        $this->fecha_fin    = Carbon::today()->addMonthNoOverflow()->format('Y-m-d');
    }

    private function loadPlanes(): void
    {
        $this->planes = Plan::where('is_active', true)->orderBy('sort_order')->get();
    }

    public function abrir(?int $cobroId = null): void
    {
        $this->loadPlanes();

        if ($cobroId) {
            $cobro = Cobros::withoutGlobalScopes()->findOrFail($cobroId);
            $this->cobroId          = $cobroId;
            $this->cliente_id       = $cobro->clientes_id;
            $this->vehiculo_id      = $cobro->vehiculos_id;
            $this->plan_id          = $cobro->plan_id;
            $this->periodo          = $cobro->periodo ?? 'MENSUAL';
            $this->divisa           = $cobro->divisa ?? 'PEN';
            $this->tipo_comprobante = $cobro->tipo_pago ?? 'FACTURA';
            $this->fecha_inicio     = $cobro->fecha_inicio?->format('Y-m-d') ?? Carbon::today()->format('Y-m-d');
            $this->fecha_fin        = $cobro->fecha_vencimiento?->format('Y-m-d') ?? Carbon::today()->addMonthNoOverflow()->format('Y-m-d');
            $this->monto            = (float) ($cobro->monto ?? 0);
            $this->descuento        = (float) ($cobro->descuento ?? 0);
            $this->nota             = $cobro->nota;
        } else {
            $this->reset(['cobroId', 'cliente_id', 'vehiculo_id', 'plan_id', 'monto', 'descuento', 'nota', 'cobrar_ahora']);
            $this->periodo          = 'MENSUAL';
            $this->divisa           = 'PEN';
            $this->tipo_comprobante = 'FACTURA';
            $this->fecha_inicio     = Carbon::today()->format('Y-m-d');
            $this->fecha_fin        = Carbon::today()->addMonthNoOverflow()->format('Y-m-d');
        }

        $this->modalOpen = true;
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
            'MENSUAL'    => Carbon::parse($fechaInicio)->addMonthNoOverflow()->subDay()->format('Y-m-d'),
            'BIMENSUAL'  => Carbon::parse($fechaInicio)->addMonthsNoOverflow(2)->subDay()->format('Y-m-d'),
            'TRIMESTRAL' => Carbon::parse($fechaInicio)->addMonthsNoOverflow(3)->subDay()->format('Y-m-d'),
            'SEMESTRAL'  => Carbon::parse($fechaInicio)->addMonthsNoOverflow(6)->subDay()->format('Y-m-d'),
            'ANUAL'      => Carbon::parse($fechaInicio)->addYearNoOverflow()->subDay()->format('Y-m-d'),
            default      => Carbon::parse($fechaInicio)->addMonthNoOverflow()->subDay()->format('Y-m-d'),
        };
    }

    public function guardar(): void
    {
        $this->validate();

        try {
            $montoFinal = max(0, round($this->monto - ($this->descuento ?? 0), 4));

            if ($this->cobroId) {
                // Ã¢â€â‚¬Ã¢â€â‚¬ EDITAR Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬
                $cobro = Cobros::withoutGlobalScopes()->findOrFail($this->cobroId);
                $cobro->update([
                    'clientes_id'       => $this->cliente_id,
                    'vehiculos_id'      => $this->vehiculo_id,
                    'plan_id'           => $this->plan_id,
                    'periodo'           => $this->periodo,
                    'divisa'            => $this->divisa,
                    'tipo_pago'         => $this->tipo_comprobante,
                    'fecha_inicio'      => $this->fecha_inicio,
                    'fecha_vencimiento' => $this->fecha_fin,
                    'monto'             => $montoFinal,
                    'descuento'         => $this->descuento ?? 0,
                    'nota'              => $this->nota,
                ]);

                $this->modalOpen = false;
                $this->dispatch('render');
                $this->dispatch(
                    'notify-toast',
                    icon: 'success',
                    title: 'ACTUALIZADO',
                    mensaje: 'Suscripción actualizada correctamente',
                );
                return;
            }

            // Ã¢â€â‚¬Ã¢â€â‚¬ CREAR Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬
            $cobro = Cobros::create([
                'clientes_id'       => $this->cliente_id,
                'vehiculos_id'      => $this->vehiculo_id,
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

            // Crear período inicial PENDIENTE
            $periodo = PeriodoCobro::create([
                'cobros_id'     => $cobro->id,
                'cliente_id'    => $this->cliente_id,
                'vehiculo_id'   => $this->vehiculo_id,
                'fecha_inicio'  => $this->fecha_inicio,
                'fecha_fin'     => $this->fecha_fin,
                'periodo'       => $this->periodo,
                'monto'         => $montoFinal,
                'divisa'        => $this->divisa,
                'tipo'          => 'INICIAL',
                'estado'        => 'PENDIENTE',
                'observaciones' => $this->nota,
            ]);

            $this->modalOpen = false;
            $this->dispatch('render');

            if ($this->cobrar_ahora) {
                $cliente = Clientes::find($this->cliente_id);
                $periodoIds = (string) $periodo->id;

                if ($this->tipo_comprobante === 'RECIBO') {
                    $this->redirect(
                        route('admin.ventas.recibos.create', ['periodo_ids' => $periodoIds]),
                        navigate: true
                    );
                    return;
                }

                if (($cliente?->tipo_documento_id ?? null) == 6) {
                    $this->redirect(
                        route('admin.factura.create', ['periodo_ids' => $periodoIds]),
                        navigate: true
                    );
                    return;
                }

                $this->redirect(
                    route('admin.boleta.create', ['periodo_ids' => $periodoIds]),
                    navigate: true
                );
                return;
            }

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'REGISTRADO',
                mensaje: 'Suscripción registrada correctamente',
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
        $this->reset(['cobroId', 'cliente_id', 'vehiculo_id', 'plan_id', 'monto', 'descuento', 'nota', 'cobrar_ahora']);
    }

    public function render()
    {
        return view('livewire.admin.cobros.registrar-cobro');
    }
}

<?php

namespace App\Livewire\Admin\Cobros;

use App\Enums\CobroEstado;
use App\Models\Cobros;
use App\Models\PeriodoCobro;
use App\Models\Plan;
use Carbon\Carbon;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Renovar extends Component
{
    use WireUiActions;

    public bool $modalOpen = false;
    public ?int $cobroId = null;

    // Datos del período a renovar
    public string $fechaInicio   = '';
    public string $fechaFin      = '';
    public string $periodo        = 'MENSUAL';
    public float $monto           = 0;
    public float $descuento       = 0;
    public string $divisa         = 'PEN';
    public string $observaciones  = '';
    public bool $cobrarAhora      = false;

    protected function rules(): array
    {
        return [
            'fechaInicio'   => 'required|date',
            'fechaFin'      => 'required|date|after:fechaInicio',
            'monto'         => 'required|numeric|min:0',
            'descuento'     => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string|max:500',
        ];
    }

    protected $listeners = [
        'abrirRenovar' => 'abrir',
    ];

    public function abrir(int $cobroId): void
    {
        $cobro = Cobros::with(['plan'])->find($cobroId);
        if (!$cobro) {
            return;
        }

        $this->cobroId = $cobroId;

        // La fecha inicio es el día siguiente al vencimiento actual
        $fechaActualFin   = $cobro->fecha_vencimiento ?? Carbon::today();
        $nuevaFechaInicio = Carbon::parse($fechaActualFin)->addDay()->format('Y-m-d');

        $this->fechaInicio   = $nuevaFechaInicio;
        $this->periodo       = $cobro->periodo ?? 'MENSUAL';
        $this->fechaFin      = $this->calcularFechaFin($nuevaFechaInicio, $this->periodo);
        $this->monto         = (float) ($cobro->monto ?? 0);
        $this->descuento     = 0;
        $this->divisa        = $cobro->divisa ?? 'PEN';
        $this->observaciones = '';
        $this->cobrarAhora   = false;

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
            $cobro      = Cobros::findOrFail($this->cobroId);
            $montoFinal = max(0, $this->monto - $this->descuento);

            // Crear el nuevo período
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

            // Actualizar fechas del cobro al nuevo período
            $cobro->update([
                'fecha_inicio'      => $this->fechaInicio,
                'fecha_vencimiento' => $this->fechaFin,
                'periodo'           => $this->periodo,
                'monto'             => $montoFinal,
                'estado'            => CobroEstado::ACTIVO,
            ]);

            $this->modalOpen = false;
            $this->dispatch('render');

            if ($this->cobrarAhora) {
                $tipoComprobante = $cobro->tipo_pago ?? 'FACTURA';
                $periodoIdsJson  = json_encode([$periodo->id]);

                if ($tipoComprobante === 'RECIBO') {
                    $this->redirect(route('admin.ventas.recibos.create', ['periodo_ids' => $periodoIdsJson]), navigate: true);
                    return;
                }

                $cliente = $cobro->clientes;
                if (($cliente?->tipo_documento_id ?? null) == 6) {
                    $this->redirect(route('admin.factura.create', ['periodo_ids' => $periodoIdsJson]), navigate: true);
                    return;
                }

                $this->redirect(route('admin.boleta.create', ['periodo_ids' => $periodoIdsJson]), navigate: true);
                return;
            }

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'PERÍODO RENOVADO',
                mensaje: 'Se registró la renovación correctamente',
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
        $this->modalOpen     = false;
    }

    public function render()
    {
        return view('livewire.admin.cobros.renovar');
    }
}

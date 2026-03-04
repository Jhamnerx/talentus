<?php

namespace App\Livewire\Admin\Cobros;

use App\Models\DetalleCobros;
use App\Models\Plan;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class ModalSyncSuscripcion extends Component
{
    use WireUiActions;

    public bool $open = false;
    public ?int $detalleId = null;
    public $planId = null;
    public string $endsAt = '';
    public string $startsAt = '';
    public array $planes = [];

    // Para la vista
    public ?DetalleCobros $detalle = null;

    public function render()
    {
        return view('livewire.admin.cobros.modal-sync-suscripcion');
    }

    #[On('abrir-modal-sync')]
    public function abrir(int $detalleId): void
    {
        $detalle = DetalleCobros::with('vehiculo', 'cobro')->find($detalleId);

        if (!$detalle || !$detalle->vehiculo) {
            $this->notification()->error('Sin vehículo', 'El detalle no tiene vehículo asignado.');
            return;
        }

        $this->detalleId = $detalleId;
        $this->detalle   = $detalle;
        $this->planId    = $detalle->plan_id;

        // Fechas del detalle de cobro
        $this->startsAt = $detalle->fecha_inicio
            ? Carbon::parse($detalle->fecha_inicio)->format('Y-m-d')
            : Carbon::parse($detalle->fecha)->format('Y-m-d');
        $this->endsAt = $detalle->fecha
            ? Carbon::parse($detalle->fecha)->format('Y-m-d')
            : Carbon::now()->format('Y-m-d');

        // Cargar planes activos filtrados por empresa
        $empresaId = $detalle->cobro?->empresa_id ?? $detalle->vehiculo->empresa_id ?? null;
        $this->planes = Plan::query()
            ->when($empresaId, fn($q) => $q->where('empresa_id', $empresaId))
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn($p) => [
                'id'    => $p->id,
                'label' => (is_array($p->name)
                    ? ($p->name['es'] ?? ($p->name['en'] ?? 'Plan #' . $p->id))
                    : $p->name)
                    . ' — S/. ' . number_format($p->price, 2),
            ])
            ->toArray();

        $this->open = true;
    }

    public function cerrar(): void
    {
        $this->reset(['open', 'detalleId', 'planId', 'endsAt', 'startsAt', 'planes', 'detalle']);
    }

    public function confirmar(): void
    {
        $this->validate([
            'planId'   => 'required|integer|exists:plans,id',
            'endsAt'   => 'required|date',
            'startsAt' => 'required|date',
        ], [
            'planId.required'  => 'Debe seleccionar un plan.',
            'endsAt.required'  => 'La fecha de vencimiento es obligatoria.',
            'startsAt.required' => 'La fecha de inicio es obligatoria.',
        ]);

        $detalle  = DetalleCobros::with('vehiculo', 'cobro')->find($this->detalleId);
        $vehiculo = $detalle?->vehiculo;

        if (!$vehiculo) {
            $this->notification()->error('Vehículo no encontrado', 'No se pudo encontrar el vehículo asociado.');
            return;
        }

        $plan = Plan::find($this->planId);
        if (!$plan) {
            $this->notification()->error('Plan no encontrado', 'El plan seleccionado no existe.');
            return;
        }

        $endsAt   = Carbon::parse($this->endsAt);
        $startsAt = Carbon::parse($this->startsAt);

        $subscription = $vehiculo->planSubscription('gps-tracking');

        if ($subscription) {
            // Cambiar plan (respeta lógica del paquete para billing frequency)
            $subscription->changePlan($plan);
            // Ajustar fechas manualmente al rango del cobro
            $subscription->forceFill([
                'starts_at'   => $startsAt,
                'ends_at'     => $endsAt,
                'canceled_at' => null,
            ])->save();
        } else {
            // Crear nueva suscripción con el método oficial del paquete
            $subscription = $vehiculo->newPlanSubscription('gps-tracking', $plan, $startsAt);
            $subscription->forceFill([
                'ends_at' => $endsAt,
            ])->save();
        }

        // Actualizar el detalle con plan, fechas y monto del plan
        $detalle->plan_id      = $plan->getKey();
        $detalle->fecha        = $endsAt->format('Y-m-d');
        $detalle->fecha_inicio = $startsAt->format('Y-m-d');
        $detalle->save();

        $placa = $vehiculo->placa;
        $this->cerrar();
        $this->dispatch('render');
        $this->notification()->success(
            'Suscripción sincronizada',
            "Vehículo {$placa} actualizado hasta " . $endsAt->format('d/m/Y') . '.'
        );
    }
}

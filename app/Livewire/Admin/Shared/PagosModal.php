<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Shared;

use Carbon\Carbon;
use App\Models\Ventas;
use App\Models\Recibos;
use App\Models\Payments;
use Livewire\Component;
use App\Models\PaymentMethodType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PaymentDestinationHelper;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use WireUi\Traits\WireUiActions;

class PagosModal extends Component
{
    use WireUiActions;
    public bool $open = false;

    /** 'Recibos' | 'Ventas' */
    public string $modelType = '';

    public int $modelId = 0;

    /** Filas nuevas a agregar */
    public array $nuevos_pagos = [];

    // -------------------------------------------------------
    //  Evento de apertura
    // -------------------------------------------------------

    #[On('abrir-pagos-modal')]
    public function abrirModal(int $id, string $type): void
    {
        $this->modelType  = $type;
        $this->modelId    = $id;
        $this->nuevos_pagos = [];
        $this->open = true;
    }

    // -------------------------------------------------------
    //  Computed helpers
    // -------------------------------------------------------

    #[Computed]
    public function model(): Ventas|Recibos|null
    {
        if (!$this->modelId) {
            return null;
        }

        if ($this->modelType === 'Ventas') {
            return Ventas::with('payments')->find($this->modelId);
        }

        return Recibos::with('payments')->find($this->modelId);
    }

    #[Computed]
    public function pagos(): \Illuminate\Database\Eloquent\Collection
    {
        if (!$this->model) {
            return collect();
        }

        return $this->model->payments()
            ->with(['paymentMethod', 'destination'])
            ->orderBy('id')
            ->get();
    }

    #[Computed]
    public function totalPagado(): float
    {
        return (float) ($this->model?->payments()->sum('monto') ?? 0);
    }

    #[Computed]
    public function totalAPagar(): float
    {
        return (float) ($this->model?->total ?? 0);
    }

    #[Computed]
    public function pendiente(): float
    {
        return round($this->totalAPagar - $this->totalPagado, 2);
    }

    #[Computed]
    public function metodosPago(): array
    {
        return PaymentMethodType::where('active', true)
            ->get()
            ->map(fn($m) => ['id' => $m->id, 'name' => $m->description])
            ->toArray();
    }

    #[Computed]
    public function destinosPago(): array
    {
        return PaymentDestinationHelper::getPaymentDestinations()->toArray();
    }

    #[Computed]
    public function divisa(): string
    {
        return $this->model?->divisa ?? 'PEN';
    }

    /** Símbolo de moneda */
    #[Computed]
    public function simbolo(): string
    {
        return $this->divisa === 'USD' ? '$' : 'S/.';
    }

    // -------------------------------------------------------
    //  Acciones
    // -------------------------------------------------------

    public function agregarFila(): void
    {
        if ($this->pendiente <= 0) {
            return;
        }

        $this->nuevos_pagos[] = [
            'fecha'                 => Carbon::now()->format('Y-m-d'),
            'metodo_pago_id'        => '',
            'payment_destination_id' => '',
            'numero_operacion'      => '',
            'monto'                 => '',
            'recibido'              => true,
        ];
    }

    public function eliminarPago(int $pagoId): void
    {
        try {
            $pago = Payments::findOrFail($pagoId);
            $pago->delete();

            // Recalcular estado de pago del modelo
            $this->actualizarEstadoPago();

            unset($this->model);   // limpiar computed cache
            unset($this->pagos);
            unset($this->totalPagado);
            unset($this->pendiente);

            $this->notification()->success(
                title: 'Pago eliminado',
                description: 'El pago fue eliminado y los saldos actualizados correctamente.'
            );
            $this->dispatch('render');
            $this->dispatch('update');
        } catch (\Throwable $e) {
            $this->notification()->error(
                title: 'Error al eliminar',
                description: $e->getMessage()
            );
        }
    }

    public function eliminarFilaNueva(int $index): void
    {
        array_splice($this->nuevos_pagos, $index, 1);
        $this->nuevos_pagos = array_values($this->nuevos_pagos);
    }

    public function guardarPagos(): void
    {
        // Validar y guardar solo filas marcadas como recibidas con monto > 0
        DB::beginTransaction();

        try {
            foreach ($this->nuevos_pagos as $i => $pago) {
                if (empty($pago['monto']) || floatval($pago['monto']) <= 0) {
                    continue;
                }

                // Validar que el monto sea numérico (rechaza formatos como 53.43.450)
                $montoLimpio = str_replace(',', '', (string) $pago['monto']);
                if (!is_numeric($montoLimpio)) {
                    throw new \Exception('La fila #' . ($i + 1) . ' tiene un monto con formato inválido: "' . $pago['monto'] . '". Use formato decimal válido (ej: 1500.00)');
                }
                $this->nuevos_pagos[$i]['monto'] = $montoLimpio;

                if (empty($pago['metodo_pago_id'])) {
                    throw new \Exception('La fila #' . ($i + 1) . ' no tiene método de pago seleccionado.');
                }

                $destino = PaymentDestinationHelper::parseDestination($pago['payment_destination_id'] ?? null);
                if (!$destino || !$destino['destination_id']) {
                    throw new \Exception('La fila #' . ($i + 1) . ' no tiene destino de pago seleccionado.');
                }

                $paymentableType = $this->modelType === 'Ventas'
                    ? Ventas::class
                    : Recibos::class;

                Payments::create([
                    'paymentable_type'   => $paymentableType,
                    'paymentable_id'     => $this->modelId,
                    'payment_method_id'  => $pago['metodo_pago_id'],
                    'destination_type'   => $destino['destination_type'],
                    'destination_id'     => $destino['destination_id'],
                    'numero_operacion'   => $pago['numero_operacion'] ?? null,
                    'monto'              => $pago['monto'],
                    'fecha'              => $pago['fecha'] ?? Carbon::now()->toDateString(),
                    'divisa'             => $this->divisa,
                    'user_id'            => Auth::user()->id,
                    'empresa_id'         => session('empresa'),
                ]);
            }

            $this->actualizarEstadoPago();
            DB::commit();

            $this->nuevos_pagos = [];

            // Limpiar caché computed
            unset($this->model);
            unset($this->pagos);
            unset($this->totalPagado);
            unset($this->pendiente);

            $this->notification()->success(
                title: 'Pagos guardados',
                description: 'Los pagos fueron registrados y los saldos actualizados correctamente.'
            );
            $this->dispatch('render');
            $this->dispatch('update');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->notification()->error(
                title: 'Error al guardar',
                description: $e->getMessage()
            );
        }
    }

    public function cerrarModal(): void
    {
        $this->open = false;
        $this->nuevos_pagos = [];
        $this->dispatch('render');
        $this->dispatch('update');
    }

    // -------------------------------------------------------
    //  Helpers internos
    // -------------------------------------------------------

    private function actualizarEstadoPago(): void
    {
        if (!$this->model) {
            return;
        }

        $totalPagadoActualizado = (float) $this->model->payments()->sum('monto');
        $total = (float) $this->model->total;

        $nuevoEstado = round($totalPagadoActualizado, 2) >= round($total, 2)
            ? 'PAID'
            : 'UNPAID';

        $updateData = ['pago_estado' => $nuevoEstado];

        // Para Recibos también actualizar estado
        if ($this->modelType === 'Recibos') {
            $updateData['estado'] = $nuevoEstado === 'PAID' ? 'COMPLETADO' : $this->model->estado;
        }

        $this->model->update($updateData);
    }

    // -------------------------------------------------------
    //  Render
    // -------------------------------------------------------

    public function render()
    {
        return view('livewire.admin.shared.pagos-modal');
    }
}

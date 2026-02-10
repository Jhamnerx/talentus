<?php

namespace App\Livewire\Admin\Cobros;

use App\Enums\CobroEstado;
use App\Models\Cobros;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use App\Models\DetalleCobros;

class Show extends Component
{
    public Cobros $cobro;

    #[Url(as: 'selected', keep: true)]
    public $detalleIds = [];

    public function mount(Cobros $cobro)
    {
        $this->cobro = $cobro;
    }

    public function render()
    {
        return view('livewire.admin.cobros.show');
    }

    public function openModalPayment(DetalleCobros $detalle)
    {
        $this->dispatch('open-modal-payment', detalle: $detalle);
    }

    public function openModalPaymentBulk()
    {
        if (empty($this->detalleIds)) {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'SELECCIÓN REQUERIDA',
                mensaje: 'Debes seleccionar al menos un vehículo para pagar'
            );
            return;
        }

        $this->dispatch('open-modal-payment-bulk', cobro: $this->cobro, detalleIds: $this->detalleIds);
    }

    public function suspenderSeleccionados()
    {
        if (empty($this->detalleIds)) {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'SELECCIÓN REQUERIDA',
                mensaje: 'Debes seleccionar al menos un vehículo para suspender'
            );
            return;
        }

        DetalleCobros::whereIn('id', $this->detalleIds)
            ->update(['estado_detalle' => CobroEstado::SUSPENDIDO, 'estado' => 0]);

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'VEHÍCULOS SUSPENDIDOS',
            mensaje: count($this->detalleIds) . ' vehículos suspendidos correctamente'
        );

        $this->detalleIds = [];
        $this->dispatch('update-cobros');
    }

    public function activarSeleccionados()
    {
        if (empty($this->detalleIds)) {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'SELECCIÓN REQUERIDA',
                mensaje: 'Debes seleccionar al menos un vehículo para activar'
            );
            return;
        }

        DetalleCobros::whereIn('id', $this->detalleIds)
            ->update(['estado_detalle' => CobroEstado::ACTIVO, 'estado' => 1]);

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'VEHÍCULOS ACTIVADOS',
            mensaje: count($this->detalleIds) . ' vehículos activados correctamente'
        );

        $this->detalleIds = [];
        $this->dispatch('update-cobros');
    }

    #[On('update-cobros')]
    public function r()
    {
        $this->render();
    }

    public function refreshFecha(DetalleCobros $detalle)
    {
        $periodo = $detalle->cobro->periodo;

        // Usar copy() para no modificar la fecha original
        $nuevaFecha = match ($periodo) {
            'MENSUAL' => $detalle->fecha->copy()->addMonth(),
            'BIMENSUAL' => $detalle->fecha->copy()->addMonths(2),
            'TRIMESTRAL' => $detalle->fecha->copy()->addMonths(3),
            'SEMESTRAL' => $detalle->fecha->copy()->addMonths(6),
            'ANUAL' => $detalle->fecha->copy()->addYear(),
            default => $detalle->fecha,
        };

        $detalle->update(['fecha' => $nuevaFecha]);

        $this->dispatch('update-cobros');

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'FECHA ACTUALIZADA',
            mensaje: 'Se actualizó la fecha correctamente'
        );
    }

    /**
     * Redirect inteligente: detecta tipo de documento y redirige al módulo correcto.
     * Almacena forma_pago en sesión para pre-seleccionarlo en Emitir/Create.
     */
    public function facturarInteligente(int $detalleId, string $formaPago = 'CONTADO')
    {
        $detalle = DetalleCobros::findOrFail($detalleId);
        $cobro = $detalle->cobro;

        // Normalizar: Emitir/Create usan CREDITO sin acento
        $formaPagoNormalizada = $formaPago === 'CRÉDITO' ? 'CREDITO' : $formaPago;

        // Guardar contexto en sesión para que Emitir/Create lo use
        session([
            'cobro_forma_pago' => $formaPagoNormalizada,
            'cobro_redirect_back' => route('admin.cobros.show', $cobro->id),
        ]);

        $detalleIds = json_encode([$detalleId]);

        // Determinar tipo de documento según configuración del cobro
        if ($cobro->tipo_pago === 'RECIBO') {
            return redirect()->route('admin.ventas.recibos.create', [
                'detalle_ids' => $detalleIds,
                'cobro_id' => $cobro->id,
            ]);
        }

        // Factura o Boleta según tipo de documento del cliente
        $tipoDocCliente = $cobro->clientes->tipo_documento_id ?? null;

        if ($tipoDocCliente == 6) {
            // RUC → Factura
            return redirect()->route('admin.factura.create', [
                'detalle_ids' => $detalleIds,
                'cobro_id' => $cobro->id,
            ]);
        }

        // DNI u otro → Boleta
        return redirect()->route('admin.boleta.create', [
            'detalle_ids' => $detalleIds,
            'cobro_id' => $cobro->id,
        ]);
    }

    /**
     * Facturar múltiples detalles seleccionados (masivo)
     */
    public function facturarMasivo(string $formaPago = 'CONTADO')
    {
        if (empty($this->detalleIds)) {
            $this->dispatch('notify-toast', icon: 'warning', title: 'SELECCIÓN REQUERIDA', mensaje: 'Selecciona al menos un vehículo');
            return;
        }

        $formaPagoNormalizada = $formaPago === 'CRÉDITO' ? 'CREDITO' : $formaPago;

        session([
            'cobro_forma_pago' => $formaPagoNormalizada,
            'cobro_redirect_back' => route('admin.cobros.show', $this->cobro->id),
        ]);

        $detalleIds = json_encode($this->detalleIds);

        if ($this->cobro->tipo_pago === 'RECIBO') {
            return redirect()->route('admin.ventas.recibos.create', [
                'detalle_ids' => $detalleIds,
                'cobro_id' => $this->cobro->id,
            ]);
        }

        $tipoDocCliente = $this->cobro->clientes->tipo_documento_id ?? null;

        if ($tipoDocCliente == 6) {
            return redirect()->route('admin.factura.create', [
                'detalle_ids' => $detalleIds,
                'cobro_id' => $this->cobro->id,
            ]);
        }

        return redirect()->route('admin.boleta.create', [
            'detalle_ids' => $detalleIds,
            'cobro_id' => $this->cobro->id,
        ]);
    }
}

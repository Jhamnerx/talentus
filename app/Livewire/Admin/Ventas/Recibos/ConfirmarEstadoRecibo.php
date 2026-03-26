<?php

namespace App\Livewire\Admin\Ventas\Recibos;

use App\Models\NotificacionCobro;
use App\Models\Recibos;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Livewire\Component;

class ConfirmarEstadoRecibo extends Component
{
    public ?Model $recibo = null;
    public bool $mostrarModal = false;

    // Acción que se va a ejecutar: 'anular' | 'activar'
    public string $accion = '';

    // Datos informativos para mostrar al usuario
    public array $pagosAsociados = [];
    public ?array $notificacion  = null;

    #[On('confirmar-estado-recibo')]
    public function abrir(int $reciboId): void
    {
        $recibo = Recibos::findOrFail($reciboId);
        $this->recibo = $recibo;
        $this->accion = $recibo->estado === Recibos::COMPLETADO ? 'anular' : 'activar';

        if ($this->accion === 'anular') {
            // Cargar pagos vigentes
            $this->pagosAsociados = $recibo->payments()
                ->with('paymentMethod')
                ->get()
                ->map(fn($p) => [
                    'numero' => $p->numero,
                    'monto'  => number_format($p->monto, 2),
                    'divisa' => $p->divisa ?? 'PEN',
                    'metodo' => $p->paymentMethod?->nombre ?? '-',
                    'fecha'  => optional($p->fecha)->format('d/m/Y') ?? '-',
                ])
                ->toArray();

            // Cobro vinculado
            $notif = NotificacionCobro::where('recibo_id', $recibo->id)->first();
            $this->notificacion = $notif
                ? [
                    'id'          => $notif->id,
                    'descripcion' => $notif->descripcion,
                    'monto'       => number_format($notif->monto, 2),
                    'moneda'      => $notif->moneda,
                    'vencimiento' => $notif->fecha_vencimiento?->format('d/m/Y') ?? '-',
                ]
                : null;
        } else {
            $this->pagosAsociados = [];
            $this->notificacion   = null;
        }

        $this->mostrarModal = true;
    }

    public function cerrar(): void
    {
        $this->mostrarModal   = false;
        $this->recibo         = null;
        $this->pagosAsociados = [];
        $this->notificacion   = null;
    }

    public function confirmar(): void
    {
        if (!$this->recibo) {
            return;
        }

        if ($this->accion === 'anular') {
            // Revertir NotificacionesCobro vinculadas
            NotificacionCobro::where('recibo_id', $this->recibo->id)
                ->each(fn($n) => $n->resetFacturacion());

            // Soft-delete de los pagos asociados
            $this->recibo->payments()->delete();

            $this->recibo->update(['estado' => Recibos::BORRADOR]);
        } else {
            $this->recibo->update(['estado' => Recibos::COMPLETADO]);
        }

        $this->cerrar();
        $this->dispatch('recibo-delete'); // reutilizamos el evento para refrescar la tabla
    }

    public function render()
    {
        return view('livewire.admin.ventas.recibos.confirmar-estado-recibo');
    }
}

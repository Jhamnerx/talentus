<?php

namespace App\Livewire\Admin\Cobros;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\NotificacionCobro;
use WireUi\Traits\WireUiActions;

/**
 * Componente para gestionar Notificaciones de Cobro
 * 
 * Muestra las notificaciones generadas automáticamente para cobros próximos a vencer.
 * Permite facturar, cancelar y ver el estado de cada notificación.
 */
class Notificaciones extends Component
{
    use WithPagination, WireUiActions;

    public $search = '';
    public $estado = 'PENDIENTE';
    public $filtroVencimiento = null;
    public $perPage = 15;

    protected $queryString = [
        'search' => ['except' => ''],
        'estado' => ['except' => 'PENDIENTE'],
        'filtroVencimiento' => ['except' => ''],
        'perPage' => ['except' => 15]
    ];

    protected $listeners = ['render'];

    public function render()
    {
        $notificaciones = NotificacionCobro::query()
            ->with(['detalleCobro.vehiculo', 'cobro', 'cliente', 'venta', 'recibo'])
            // Búsqueda
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('cliente', function ($clienteQuery) {
                        $clienteQuery->where('razon_social', 'like', '%' . $this->search . '%');
                    })
                        ->orWhereHas('detalleCobro.vehiculo', function ($vehiculoQuery) {
                            $vehiculoQuery->where('placa', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('descripcion', 'like', '%' . $this->search . '%');
                });
            })
            // Filtro por estado
            ->when($this->estado, function ($query) {
                $query->where('estado', $this->estado);
            })
            // Filtro por vencimiento
            ->when($this->filtroVencimiento === 'vencidos', function ($query) {
                $query->vencidos();
            })
            ->when($this->filtroVencimiento === 'hoy', function ($query) {
                $query->whereDate('fecha_vencimiento', now());
            })
            ->when($this->filtroVencimiento === '7dias', function ($query) {
                $query->porVencer(7);
            })
            ->when($this->filtroVencimiento === '15dias', function ($query) {
                $query->porVencer(15);
            })
            ->orderBy('fecha_vencimiento', 'asc')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        // Estadísticas para dashboard
        $stats = [
            'pendientes' => NotificacionCobro::pendientes()->count(),
            'vencidos' => NotificacionCobro::vencidos()->count(),
            'hoy' => NotificacionCobro::pendientes()
                ->whereDate('fecha_vencimiento', now())
                ->count(),
            'monto_pendiente' => NotificacionCobro::pendientes()
                ->sum('monto'),
        ];

        return view('livewire.admin.cobros.notificaciones', compact('notificaciones', 'stats'));
    }

    public function redirectToFacturar($notificacionId)
    {
        $notificacion = NotificacionCobro::with(['detalleCobro', 'cobro.clientes'])->find($notificacionId);

        if (!$notificacion) {
            $this->notification()->error('Notificación no encontrada');
            return;
        }

        $detalle = $notificacion->detalleCobro;
        $cobro = $notificacion->cobro;
        $cliente = $cobro->clientes;

        // Guardar contexto en sesión para que Emitir/Create lo use
        session([
            'cobro_forma_pago' => 'CONTADO',
            'cobro_redirect_back' => route('admin.cobros.notificaciones'),
            'notificacion_cobro_id' => $notificacionId, // Para asociar después
        ]);

        $detalleIds = json_encode([$detalle->id]);

        // Determinar tipo de documento según configuración del cobro
        if ($cobro->tipo_pago === 'RECIBO') {
            return redirect()->route('admin.ventas.recibos.create', [
                'detalle_ids' => $detalleIds,
                'cobro_id' => $cobro->id,
            ]);
        }

        // Factura o Boleta según tipo de documento del cliente
        $tipoDocCliente = $cliente->tipo_documento_id ?? null;

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

    public function cancelar($notificacionId)
    {
        $this->dialog()->confirm([
            'title' => '¿Cancelar notificación?',
            'description' => 'Esta acción no se puede deshacer',
            'icon' => 'warning',
            'accept' => [
                'label' => 'Sí, cancelar',
                'method' => 'confirmarCancelacion',
                'params' => $notificacionId,
            ],
            'reject' => [
                'label' => 'No, volver',
            ],
        ]);
    }

    public function confirmarCancelacion($notificacionId)
    {
        try {
            $notificacion = NotificacionCobro::findOrFail($notificacionId);
            $notificacion->cancelar('Cancelado desde el panel de notificaciones');

            $this->notification()->success('Notificación cancelada correctamente');
            $this->dispatch('render');
        } catch (\Exception $e) {
            $this->notification()->error('Error al cancelar: ' . $e->getMessage());
        }
    }

    public function clearFilters()
    {
        $this->reset(['search', 'estado', 'filtroVencimiento']);
        $this->resetPage();
    }
}

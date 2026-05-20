<?php

namespace App\Livewire\Admin\WorkOrders;

use App\Models\User;
use App\Models\Ciudades;
use App\Models\WorkOrder;
use App\Models\WorkOrderType;
use App\Enums\WorkOrderStatus;
use App\Services\WorkOrderNotificationService;
use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WhatsappGroup;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WithPagination, WireUiActions;

    public $search = '';
    public $estado_filter = '';
    public $tecnico_filter = '';
    public $fecha_desde = '';
    public $fecha_hasta = '';
    public $perPage = 10;

    // Configuración de técnicos WA
    public bool $modalTecnicoConfig = false;
    public $tecnicoConfigId = null;
    public $tecnicoConfigCiudad = '';
    public $tecnicoConfigGrupo = '';

    // Dispositivo WA seleccionado para enviar notificaciones
    public ?int $selectedWaDeviceId = null;

    // Modal cancelar orden
    public bool $modalCancelar = false;
    public ?int $cancelarOrdenId = null;
    public string $motivoCancelacion = '';

    // Confirmar eliminar
    public ?int $eliminarOrdenId = null;

    public function mount(): void
    {
        $this->authorize('ver-work_order');
    }

    #[On('work-order-created')]
    public function refresh()
    {
        // Refresh automático después de crear
    }

    #[On('work-order-updated')]
    public function refreshUpdated()
    {
        // Refresh automático después de actualizar
    }

    #[On('tipo-guardado')]
    public function refreshTipos()
    {
        // Refresh automático después de guardar tipo
    }

    public function render()
    {
        $stats = [
            'pendientes' => WorkOrder::estado(WorkOrderStatus::PENDIENTE)->count(),
            'en_proceso' => WorkOrder::estado(WorkOrderStatus::EN_PROCESO)->count(),
            'finalizadas' => WorkOrder::estado(WorkOrderStatus::FINALIZADO)->count(),
            'canceladas' => WorkOrder::estado(WorkOrderStatus::CANCELADO)->count(),
        ];

        $ordenes = WorkOrder::query()
            ->with(['tipo', 'vehiculo', 'cliente', 'tecnico'])
            ->when($this->search, function ($query) {
                $query->where('id', 'like', "%{$this->search}%")
                    ->orWhereHas('vehiculo', function ($q) {
                        $q->where('placa', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('cliente', function ($q) {
                        $q->where('razon_social', 'like', "%{$this->search}%");
                    });
            })
            ->when($this->estado_filter, fn($q) => $q->estado($this->estado_filter))
            ->when($this->tecnico_filter, fn($q) => $q->tecnico($this->tecnico_filter))
            ->when($this->fecha_desde, fn($q) => $q->whereDate('fecha_programada', '>=', $this->fecha_desde))
            ->when($this->fecha_hasta, fn($q) => $q->whereDate('fecha_programada', '<=', $this->fecha_hasta))
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        // Cargar tipos de órdenes
        $tipos = WorkOrderType::withCount('workOrders')->orderBy('nombre')->get();

        // Dispositivos WA conectados del usuario actual
        $waDevices = auth()->user()->waDevices()->where('status', 'Connected')->get();

        // Inicializar/validar el dispositivo seleccionado
        if (!$this->selectedWaDeviceId || !$waDevices->contains('id', $this->selectedWaDeviceId)) {
            $this->selectedWaDeviceId = $waDevices->first()?->id;
        }
        $waDevice = $waDevices->find($this->selectedWaDeviceId)
            ?? auth()->user()->waDevices()->first();

        // Técnicos con su config WA
        // wa_conectado = si el usuario ACTUAL (quien crea la orden) tiene dispositivo conectado
        $usuarioTieneDispositivo = $waDevices->isNotEmpty();

        $tecnicos = User::role('tecnico')
            ->with('ciudad')
            ->orderBy('name')
            ->get()
            ->each(fn($t) => $t->wa_conectado = $usuarioTieneDispositivo);

        $ciudades = Ciudades::where('is_active', true)->orderBy('nombre')->get();

        // Grupos WA disponibles (del dispositivo conectado del usuario)
        $waGroups = $waDevice
            ? WhatsappGroup::where('user_id', auth()->id())->orderBy('name')->get()
            : collect();

        return view('livewire.admin.work-orders.index', compact('stats', 'ordenes', 'tipos', 'waDevice', 'waDevices', 'tecnicos', 'ciudades', 'waGroups'));
    }

    public function openCreateModal()
    {
        $this->dispatch('open-create-modal');
    }

    public function verDetalle(WorkOrder $orden)
    {
        return redirect()->route('admin.work-orders.show', $orden);
    }

    public function editarOrden(WorkOrder $orden)
    {
        $this->dispatch('open-edit-modal', workOrderId: $orden->id);
    }

    public function iniciarOrden(WorkOrder $orden)
    {
        try {
            $orden->iniciar();
            $this->notification()->success('ORDEN INICIADA', "Orden {$orden->id} iniciada correctamente");
        } catch (\Exception $e) {
            $this->notification()->error('ERROR', $e->getMessage());
        }
    }

    public function finalizarOrden($ordenId, $observaciones = null)
    {
        try {
            $orden = WorkOrder::findOrFail($ordenId);

            if ($observaciones) {
                $orden->observaciones_final = $observaciones;
                $orden->save();
            }

            $orden->finalizar();
            $this->notification()->success('ORDEN FINALIZADA', "Orden {$orden->id} finalizada correctamente");
        } catch (\Exception $e) {
            $this->notification()->error('ERROR', $e->getMessage());
        }
    }

    public function cerrarOrden(WorkOrder $orden)
    {
        try {
            $orden->cerrar();
            $this->notification()->success('ORDEN CERRADA', "Orden {$orden->id} cerrada y bloqueada");
        } catch (\Exception $e) {
            $this->notification()->error('ERROR', $e->getMessage());
        }
    }

    public function abrirModalCancelar(int $ordenId): void
    {
        $this->cancelarOrdenId   = $ordenId;
        $this->motivoCancelacion = '';
        $this->modalCancelar     = true;
    }

    public function cancelarOrden(): void
    {
        $this->validate(['motivoCancelacion' => 'required|min:5'], [
            'motivoCancelacion.required' => 'El motivo de cancelación es obligatorio.',
            'motivoCancelacion.min'      => 'El motivo debe tener al menos 5 caracteres.',
        ]);

        try {
            $orden = WorkOrder::findOrFail($this->cancelarOrdenId);
            $orden->cancelar($this->motivoCancelacion);
            $this->modalCancelar = false;
            $this->notification()->success('ORDEN CANCELADA', "Orden #{$orden->id} cancelada correctamente");
        } catch (\Exception $e) {
            $this->notification()->error('ERROR', $e->getMessage());
        }
    }

    public function eliminarOrden(int $ordenId): void
    {
        $orden = WorkOrder::findOrFail($ordenId);

        if ($orden->estado->value !== 'pendiente') {
            $this->notification()->error('NO PERMITIDO', 'Solo se pueden eliminar órdenes en estado pendiente.');
            return;
        }

        // Verificar si tiene relaciones dependientes
        $tieneRelaciones = $orden->deviceHistory()->exists()
            || $orden->checklists()->exists()
            || $orden->photos()->exists()
            || $orden->signatures()->exists()
            || $orden->accessories()->exists();

        if ($tieneRelaciones) {
            $this->notification()->error('NO PERMITIDO', 'La orden tiene datos asociados (checklist, fotos, firmas o accesorios) y no puede eliminarse.');
            return;
        }

        $id = $orden->id;
        $orden->delete();
        $this->eliminarOrdenId = null;
        $this->notification()->success('ELIMINADO', "Orden #{$id} eliminada correctamente");
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->reset(['search', 'estado_filter', 'tecnico_filter', 'fecha_desde', 'fecha_hasta']);
    }

    // ========== TIPOS DE ÓRDENES ==========

    public function crearTipo()
    {
        $this->dispatch('open-tipo-modal');
    }

    public function editarTipo(WorkOrderType $tipo)
    {
        $this->dispatch('open-tipo-modal', tipoId: $tipo->id);
    }

    public function toggleActivoTipo(WorkOrderType $tipo)
    {
        $tipo->update(['is_active' => !$tipo->is_active]);
        $this->notification()->success('ACTUALIZADO', "Tipo '{$tipo->nombre}' " . ($tipo->is_active ? 'activado' : 'desactivado'));
    }

    public function eliminarTipo(WorkOrderType $tipo)
    {
        if ($tipo->workOrders()->exists()) {
            $this->notification()->error('ERROR', 'No se puede eliminar un tipo con órdenes asociadas');
            return;
        }

        $tipo->delete();
        $this->notification()->success('ELIMINADO', "Tipo '{$tipo->nombre}' eliminado correctamente");
    }

    // ========== EXPORTACIÓN ==========

    public function abrirModalExport()
    {
        $this->dispatch('open-export-modal');
    }

    // ========== NOTIFICACIONES WHATSAPP ==========

    public function reenviarNotificacionWA(int $ordenId): void
    {
        $orden = WorkOrder::findOrFail($ordenId);

        // Usar el dispositivo seleccionado por el usuario en la UI
        $device = $this->selectedWaDeviceId
            ? Device::find($this->selectedWaDeviceId)
            : auth()->user()->waDevices()->where('status', 'Connected')->first();

        $messageId = app(WorkOrderNotificationService::class)->enviarAlGrupo($orden, $device);

        if ($messageId) {
            $this->notification()->success(
                title: 'WA Enviado',
                description: "Notificación enviada correctamente (ID: {$messageId})"
            );
        } else {
            // Obtener info del device para el mensaje de error
            $deviceInfo = $this->selectedWaDeviceId
                ? Device::find($this->selectedWaDeviceId)?->body
                : auth()->user()->waDevices()->where('status', 'Connected')->first()?->body;

            $this->notification()->error(
                title: 'Error WA',
                description: 'No se pudo enviar. Revisa el log de Laravel para más detalles.'
                    . ($deviceInfo ? " (device: {$deviceInfo})" : ' — sin dispositivo conectado')
            );
        }
    }

    // ========== CONFIGURACIÓN WA DE TÉCNICOS ==========

    public function abrirConfigTecnico(int $id): void
    {
        $tecnico = User::findOrFail($id);
        $this->tecnicoConfigId     = $id;
        $this->tecnicoConfigCiudad = $tecnico->ciudad_id;
        $this->tecnicoConfigGrupo  = $tecnico->wa_group_id;
        $this->modalTecnicoConfig  = true;
    }

    public function guardarConfigTecnico(): void
    {
        $this->validate([
            'tecnicoConfigCiudad' => 'nullable|exists:ciudades,id',
            'tecnicoConfigGrupo'  => 'nullable|string|max:100',
        ]);

        User::findOrFail($this->tecnicoConfigId)->update([
            'ciudad_id'   => $this->tecnicoConfigCiudad ?: null,
            'wa_group_id' => $this->tecnicoConfigGrupo  ?: null,
        ]);

        $this->modalTecnicoConfig = false;
        $this->notification()->success('GUARDADO', 'Configuración del técnico actualizada.');
    }
}

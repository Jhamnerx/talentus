<?php

namespace App\Livewire\Admin\Cobros;

use App\Models\Cobros;
use App\Models\DetalleCobros;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination, WireUiActions;

    public $search;
    public $estado;
    public $filtroFecha;
    public $filtroVencimiento;
    public $clienteId;
    public $perPage = 15;

    protected $listeners = [
        'render'
    ];

    public function render()
    {
        $hoy = Carbon::now();
        $fechaLimiteProximos7 = $hoy->copy()->addDays(7);
        $fechaFinMes = $hoy->copy()->endOfMonth();
        $fechaProximoMes = $hoy->copy()->addMonth();

        // Obtener detalles con sus relaciones
        $detalles = DetalleCobros::query()
            ->with(['vehiculo.cliente', 'vehiculo.planSubscriptions.plan', 'cobro.clientes.contactos', 'plan'])
            // Excluir detalles de cobros eliminados
            ->whereHas('cobro', function ($query) {
                $query->whereNull('deleted_at');
            })
            // Filtro por cliente específico
            ->when($this->clienteId, function ($query) {
                $query->whereHas('cobro.clientes', function ($cliente) {
                    $cliente->where('id', $this->clienteId);
                });
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    // Búsqueda por cliente
                    $q->whereHas('cobro.clientes', function ($cliente) {
                        $cliente->where('razon_social', 'like', '%' . $this->search . '%')
                            ->orWhereHas('contactos', function ($contacto) {
                                $contacto->where('nombre', 'like', '%' . $this->search . '%');
                            });
                    })
                        // Búsqueda por placa
                        ->orWhereHas('vehiculo', function ($vehiculo) {
                            $vehiculo->where('placa', 'like', '%' . $this->search . '%');
                        });
                });
            })
            // Filtro por estado del detalle
            ->when($this->estado !== null, function ($query) {
                $query->where('estado', $this->estado);
            })
            // FILTROS DE REGISTROS (cobros creados)
            ->when($this->filtroFecha === 'registrados_7dias', function ($query) use ($hoy) {
                $query->whereHas('cobro', function ($cobro) use ($hoy) {
                    $cobro->whereBetween('created_at', [$hoy->copy()->subDays(7), $hoy]);
                });
            })
            ->when($this->filtroFecha === 'registrados_mes', function ($query) use ($hoy) {
                $query->whereHas('cobro', function ($cobro) use ($hoy) {
                    $cobro->whereBetween('created_at', [$hoy->copy()->startOfMonth(), $hoy]);
                });
            })
            // FILTROS DE VENCIMIENTO (detalles que vencen)
            ->when($this->filtroVencimiento === 'vencen_7dias', function ($query) use ($hoy, $fechaLimiteProximos7) {
                $query->where('estado', 1)

                    ->whereBetween('fecha', [$hoy->format('Y-m-d'), $fechaLimiteProximos7->format('Y-m-d')]);
            })
            ->when($this->filtroVencimiento === 'vencen_fin_mes', function ($query) use ($hoy, $fechaFinMes) {
                $query->where('estado', 1)

                    ->whereBetween('fecha', [$hoy->format('Y-m-d'), $fechaFinMes->format('Y-m-d')]);
            })
            ->when($this->filtroVencimiento === 'vencen_proximo_mes', function ($query) use ($hoy, $fechaProximoMes) {
                $query->where('estado', 1)

                    ->whereBetween('fecha', [$hoy->format('Y-m-d'), $fechaProximoMes->format('Y-m-d')]);
            })
            ->when($this->filtroVencimiento === 'vencidos', function ($query) use ($hoy) {
                $query->where('estado', 1)

                    ->where('fecha', '<', $hoy->format('Y-m-d'));
            })
            ->orderBy('fecha', 'asc')
            ->paginate($this->perPage);

        return view('livewire.admin.cobros.index', compact('detalles'));
    }

    public function setEstado($estado = null)
    {
        $this->estado = $estado;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function setFiltroFecha($filtro = null)
    {
        $this->filtroFecha = $filtro;
        $this->resetPage();
    }

    public function setFiltroVencimiento($filtro = null)
    {
        $this->filtroVencimiento = $filtro;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'estado', 'filtroFecha', 'filtroVencimiento', 'clienteId']);
        $this->resetPage();
    }

    public function updatingClienteId()
    {
        $this->resetPage();
    }

    public function openModalDelete(Cobros $cobro)
    {
        $this->dispatch('openModalDelete', $cobro);
    }

    public function cambiarEstado(DetalleCobros $detalleCobros)
    {
        $detalleCobros->estado = !$detalleCobros->estado;
        $detalleCobros->save();
    }

    public function createInvoice(Cobros $cobro): void
    {
        $this->dispatch('open-modal-create-invoice', cobro: $cobro);
    }

    /**
     * Despacha el evento para que ModalSyncSuscripcion abra el modal.
     */
    public function abrirModalSync(int $detalleId): void
    {
        $this->dispatch('abrir-modal-sync', detalleId: $detalleId);
    }
}

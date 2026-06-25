<?php

namespace App\Livewire\Admin\Cobros;

use App\Enums\CobroEstado;
use App\Exports\CobrosExport;
use App\Models\Cobros;
use App\Models\PeriodoCobro;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination, WireUiActions;

    public $search = '';
    public $estado;
    public $filtroFecha;
    public $filtroVencimiento;
    public $clienteId;
    public $perPage = 15;

    // Multi-selección para cobrar
    public array $selected = [];

    protected $listeners = [
        'render',
        'cobrosImportados' => '$refresh',
    ];

    public function render()
    {
        $hoy = Carbon::today();

        $cobros = Cobros::query()
            ->with([
                'vehiculo',
                'clientes.contactos',
                'plan',
                'periodos' => fn($q) => $q->latest('fecha_fin')->limit(3),
            ])
            ->when($this->clienteId, fn($q) => $q->where('clientes_id', $this->clienteId))
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('vehiculo', fn($v) => $v->where('placa', 'like', '%' . $this->search . '%'))
                        ->orWhereHas('clientes', function ($c) {
                            $c->where('razon_social', 'like', '%' . $this->search . '%')
                                ->orWhereHas('contactos', fn($ct) => $ct->where('nombre', 'like', '%' . $this->search . '%'));
                        });
                });
            })
            ->when($this->estado !== null, fn($q) => $q->where('estado', $this->estado))
            ->when($this->filtroFecha === 'registrados_7dias', fn($q) => $q->where('created_at', '>=', $hoy->copy()->subDays(7)))
            ->when($this->filtroFecha === 'registrados_mes', fn($q) => $q->whereBetween('created_at', [$hoy->copy()->startOfMonth(), $hoy]))
            ->when($this->filtroVencimiento === 'vencen_7dias', fn($q) => $q->where('estado', CobroEstado::ACTIVO)->whereBetween('fecha_vencimiento', [$hoy, $hoy->copy()->addDays(7)]))
            ->when($this->filtroVencimiento === 'vencen_fin_mes', fn($q) => $q->where('estado', CobroEstado::ACTIVO)->whereBetween('fecha_vencimiento', [$hoy, $hoy->copy()->endOfMonth()]))
            ->when($this->filtroVencimiento === 'vencen_proximo_mes', fn($q) => $q->where('estado', CobroEstado::ACTIVO)->whereBetween('fecha_vencimiento', [$hoy, $hoy->copy()->addMonth()]))
            ->when($this->filtroVencimiento === 'vencidos', fn($q) => $q->where('estado', CobroEstado::ACTIVO)->where('fecha_vencimiento', '<', $hoy))
            ->orderBy('clientes_id', 'asc')
            ->orderBy('fecha_vencimiento', 'asc')
            ->paginate($this->perPage);

        return view('livewire.admin.cobros.index', compact('cobros'));
    }

    public function renovarSeleccionados(): void
    {
        if (empty($this->selected)) {
            $this->dispatch('notify-toast', icon: 'warning', title: 'Sin selección', mensaje: 'Selecciona al menos un cobro');
            return;
        }

        $cobros = Cobros::withoutGlobalScopes()->whereIn('id', $this->selected)->get();

        if ($cobros->pluck('periodo')->unique()->count() > 1) {
            $this->dispatch('notify-toast', icon: 'warning', title: 'Período diferente', mensaje: 'Todos los cobros seleccionados deben tener el mismo período de facturación (MENSUAL, TRIMESTRAL, etc.)');
            return;
        }

        $this->dispatch('abrirRenovarMultiple', cobroIds: $this->selected);
    }

    public function cobrarSeleccionados(): void
    {
        if (empty($this->selected)) {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'Sin selección',
                mensaje: 'Selecciona al menos un vehículo',
            );
            return;
        }

        // Solo el último período PENDIENTE por cobro
        $periodos = collect($this->selected)->map(
            fn($cobroId) => PeriodoCobro::where('cobros_id', $cobroId)
                ->where('estado', 'PENDIENTE')
                ->orderByDesc('fecha_inicio')
                ->first()
        )->filter()->values();

        if ($periodos->isEmpty()) {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'Sin períodos pendientes',
                mensaje: 'Los vehículos seleccionados no tienen períodos pendientes de facturar',
            );
            return;
        }

        $primerCobro = Cobros::withoutGlobalScopes()->with('clientes')->find($this->selected[0]);
        $tipo    = $primerCobro->tipo_pago ?? 'FACTURA';
        $cliente = $primerCobro->clientes;

        $periodoIds = $periodos->pluck('id')->implode(',');

        session(['cobro_redirect_back' => route('admin.cobros.index')]);

        if ($tipo === 'RECIBO') {
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
    }

    public function clearSelected(): void
    {
        $this->selected = [];
    }

    public function setEstado($estado = null)
    {
        $this->estado = $estado;
        $this->resetPage();
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

    public function cambiarEstado(Cobros $cobro): void
    {
        $cobro->estado = $cobro->estado === CobroEstado::ACTIVO
            ? CobroEstado::CANCELADO
            : CobroEstado::ACTIVO;
        $cobro->save();

        $this->dispatch(
            'notify-toast',
            icon: $cobro->estado === CobroEstado::ACTIVO ? 'success' : 'warning',
            title: $cobro->estado === CobroEstado::ACTIVO ? 'ACTIVADO' : 'CANCELADO',
            mensaje: 'Estado del cobro actualizado correctamente',
        );
    }

    public function exportar()
    {
        $nombre = 'cobros_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new CobrosExport(
            search: $this->search,
            estado: $this->estado,
            clienteId: $this->clienteId,
            filtroFecha: $this->filtroFecha,
            filtroVencimiento: $this->filtroVencimiento,
        ), $nombre);
    }
}

<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Models\Clientes;
use App\Models\Reportes;
use App\Models\DetalleReportes;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $estado_filter = '';

    #[Url(except: '')]
    public string $origen_filter = '';

    #[Url(except: '')]
    public string $from = '';

    #[Url(except: '')]
    public string $to = '';

    #[Url(except: 15)]
    public int $perPage = 15;

    // Detalle inline
    public ?int $detalleAbierto = null;
    public string $nuevoDetalle = '';

    protected $listeners = ['update-table' => '$refresh'];

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $reportes = Reportes::with(['vehiculos.cliente.contactos', 'user', 'atendidoPor', 'detalle.user'])
            ->withCount('detalle as notas_count')
            ->when($this->estado_filter !== '', fn($q) => $q->where('estado', $this->estado_filter))
            ->when($this->origen_filter !== '', fn($q) => $q->where('origen', $this->origen_filter))
            ->when(!empty($desde), fn($q) => $q->whereRaw(
                '(created_at >= ? AND created_at <= ?)',
                [$desde . ' 00:00:00', $hasta . ' 23:59:59']
            ))
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->whereHas(
                        'vehiculos',
                        fn($v) => $v
                            ->where('placa', 'like', '%' . $this->search . '%')
                            ->orWhere('marca', 'like', '%' . $this->search . '%')
                            ->orWhereHas('cliente', fn($c) => $c->where('razon_social', 'like', '%' . $this->search . '%'))
                    )
                        ->orWhere('detalle', 'like', '%' . $this->search . '%')
                        ->orWhere('fecha_t', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByRaw('FIELD(estado, 1, 2, 3)')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $counts = [
            'abiertas'     => Reportes::where('estado', Reportes::ESTADO_ABIERTA)->count(),
            'en_atencion'  => Reportes::where('estado', Reportes::ESTADO_EN_ATENCION)->count(),
            'cerradas_hoy' => Reportes::where('estado', Reportes::ESTADO_CERRADA)->whereDate('cerrado_at', today())->count(),
            'auto_hoy'     => Reportes::where('origen', 'auto')->whereDate('created_at', today())->count(),
        ];

        return view('livewire.admin.vehiculos.reportes.index', compact('reportes', 'counts'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingEstadoFilter(): void
    {
        $this->resetPage();
    }

    public function updatingOrigenFilter(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function limpiarFiltros(): void
    {
        $this->reset(['search', 'estado_filter', 'origen_filter', 'from', 'to']);
        $this->resetPage();
    }

    public function filter($dias): void
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to   = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime('-7 days'));
                $this->to   = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime('-1 month'));
                $this->to   = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to   = '';
                break;
        }
        $this->resetPage();
    }

    // ──── ACCIONES INLINE ────────────────────────────────────────────

    public function atender(Reportes $reporte): void
    {
        $reporte->update([
            'estado'       => Reportes::ESTADO_EN_ATENCION,
            'atendido_por' => Auth::id(),
            'atendido_at'  => now(),
        ]);

        $this->addDetalle($reporte, '🔵 Alerta tomada por ' . Auth::user()->name);
    }

    public function cerrar(Reportes $reporte): void
    {
        $reporte->update([
            'estado'     => Reportes::ESTADO_CERRADA,
            'cerrado_at' => now(),
        ]);

        $this->addDetalle($reporte, '✅ Alerta cerrada por ' . Auth::user()->name);
    }

    public function reabrir(Reportes $reporte): void
    {
        $reporte->update([
            'estado'       => Reportes::ESTADO_ABIERTA,
            'atendido_por' => null,
            'atendido_at'  => null,
            'cerrado_at'   => null,
        ]);
    }

    private function addDetalle(Reportes $reporte, string $texto): void
    {
        DetalleReportes::create([
            'reportes_id' => $reporte->id,
            'detalle'     => $texto,
            'user_id'     => Auth::id(),
        ]);
    }

    // ──── DETALLE EXPANDIBLE ─────────────────────────────────────────

    public function toggleDetalle(int $reporteId): void
    {
        $this->detalleAbierto = $this->detalleAbierto === $reporteId ? null : $reporteId;
        $this->nuevoDetalle   = '';
    }

    public function guardarDetalle(Reportes $reporte): void
    {
        $this->validate(['nuevoDetalle' => 'required|string|min:3']);

        DetalleReportes::create([
            'reportes_id' => $reporte->id,
            'detalle'     => $this->nuevoDetalle,
            'user_id'     => Auth::id(),
        ]);

        $this->nuevoDetalle = '';
        $reporte->load('detalle.user');
    }

    // ──── MODALES ────────────────────────────────────────────────────

    public function openModalSave(): void
    {
        $this->dispatch('open-modal-save');
    }

    public function openModalEdit(Reportes $reporte): void
    {
        $this->dispatch('editarReporte', reporte: $reporte);
    }

    public function openModalDelete(Reportes $reporte): void
    {
        $this->dispatch('EliminarReporte', reporte: $reporte);
    }

    public function openModalRecordatorio(Reportes $reporte): void
    {
        $this->dispatch('crearRecordatorio', reporte: $reporte->id);
    }

    public function openModalContactos(Clientes $cliente): void
    {
        $this->dispatch('showContactos', $cliente);
    }

    public function openModalEstadoTransmision(): void
    {
        $this->dispatch('abrirEstadoTransmision');
    }

    #[On('update-table')]
    public function refresh(): void
    {
        // listener para re-render
    }
}

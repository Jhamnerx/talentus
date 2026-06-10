<?php

namespace App\Livewire\Admin\Vehiculos;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Plan;
use App\Models\Sector;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Exports\VehiculosExport;
use Maatwebsite\Excel\Facades\Excel;

class VehiculosIndex extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $from = '';

    #[Url(except: '')]
    public string $to = '';

    #[Url(except: null)]
    public $clientes_id = null;

    #[Url(except: '')]
    public string $marca_filter = '';

    #[Url(except: null)]
    public ?int $plan_filter = null;

    #[Url(except: null)]
    public ?int $sector_filter = null;

    #[Url(except: '')]
    public string $estado_filter = '';

    #[Url(except: '')]
    public string $gpswox_filter = '';

    #[Url(except: 15)]
    public int $perPage = 15;

    protected $listeners = [
        'update-table' => 'render',
        'echo:vehiculos,VehiculosImportUpdated' => 'updateVehiculos'
    ];

    public function updateVehiculos(): void
    {
        $this->render();
        $this->dispatch('vehiculos-import');
    }

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $vehiculos = Vehiculos::query()
            ->with([
                'planSubscriptions',
                'cobro',
                'sectores',
                'cliente',
                'sim_card.linea.operador',
                'dispositivoPrincipal.dispositivo.modelo',
                'dispositivos.dispositivo.modelo',
            ])
            ->when($this->clientes_id, fn($q) => $q->where('clientes_id', $this->clientes_id))
            ->when($this->marca_filter, fn($q) => $q->where('marca', $this->marca_filter))
            ->when($this->sector_filter, fn($q) => $q->whereHas('sectores', fn($s) => $s->where('sectores.id', $this->sector_filter)))
            ->when($this->plan_filter, fn($q) => $q->whereHas(
                'planSubscriptions',
                fn($s) => $s->where('plan_id', $this->plan_filter)->whereNull('canceled_at')
            ))
            ->when($this->estado_filter !== '', fn($q) => $q->where('estado', $this->estado_filter))
            ->when($this->gpswox_filter === 'activo', fn($q) => $q->where('gpswox_active', true))
            ->when($this->gpswox_filter === 'inactivo', fn($q) => $q->where('gpswox_active', false))
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('sim_card', function ($sq) {
                        $sq->where('sim_card', 'LIKE', '%' . $this->search . '%')
                           ->orWhereHas('linea', fn($l) => $l->where('numero', 'LIKE', '%' . $this->search . '%'));
                    })
                    ->orWhereHas('cliente', fn($c) => $c->where('razon_social', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('numero_documento', 'LIKE', '%' . $this->search . '%')
                    )
                    ->orWhereHas('dispositivosAsignados', fn($d) => $d->where('dispositivos.imei', 'LIKE', '%' . $this->search . '%'))
                    ->orWhere('placa', 'like', '%' . $this->search . '%')
                    ->orWhere('marca', 'like', '%' . $this->search . '%')
                    ->orWhere('modelo', 'like', '%' . $this->search . '%')
                    ->orWhere('tipo', 'like', '%' . $this->search . '%')
                    ->orWhere('color', 'like', '%' . $this->search . '%')
                    ->orWhere('motor', 'like', '%' . $this->search . '%')
                    ->orWhere('serie', 'like', '%' . $this->search . '%')
                    ->orWhere('old_numero', 'like', '%' . $this->search . '%')
                    ->orWhere('old_sim_card', 'like', '%' . $this->search . '%')
                    ->orWhere('year', 'like', '%' . $this->search . '%');
                });
            })
            ->when(!empty($desde), fn($q) => $q->whereRaw(
                '(created_at >= ? AND created_at <= ?)',
                [$desde . ' 00:00:00', $hasta . ' 23:59:59']
            ))
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $total = Vehiculos::count();

        $marcas = Vehiculos::select('marca')
            ->distinct()
            ->whereNotNull('marca')
            ->where('marca', '!=', '')
            ->orderBy('marca')
            ->pluck('marca');

        $planes = Plan::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn($p) => [
                'id'   => $p->id,
                'name' => is_array($p->name) ? ($p->name['es'] ?? ($p->name['en'] ?? 'Sin nombre')) : $p->name,
            ]);

        $sectores = Sector::activos()->get(['id', 'nombre']);

        return view('livewire.admin.vehiculos.vehiculos-index', compact('vehiculos', 'total', 'marcas', 'planes', 'sectores'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingEstadoFilter(): void
    {
        $this->resetPage();
    }

    public function updatingGpswoxFilter(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->clientes_id    = null;
        $this->marca_filter   = '';
        $this->plan_filter    = null;
        $this->sector_filter  = null;
        $this->search         = '';
        $this->from           = '';
        $this->to             = '';
        $this->estado_filter  = '';
        $this->gpswox_filter  = '';
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
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . '- 7 days'));
                $this->to   = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . '- 1 month'));
                $this->to   = date('Y-m-d');
                break;
            case '12':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . '- 1 year'));
                $this->to   = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to   = '';
                break;
        }
    }

    public function openModalSave(): void
    {
        $this->dispatch('open-modal-save');
    }

    public function openModalEdit(Vehiculos $vehiculo): void
    {
        $this->dispatch('open-modal-edit', vehiculo: $vehiculo);
    }

    public function openModalImport(): void
    {
        $this->dispatch('open-modal.import');
    }

    public function deleteVehiculo(Vehiculos $vehiculo): void
    {
        $this->dispatch('open-modal-delete', vehiculo: $vehiculo);
    }

    public function suspendVehiculo(Vehiculos $vehiculo): void
    {
        $this->dispatch('open-modal-suspend-vehiculo', $vehiculo);
    }

    public function activarVehiculo(Vehiculos $vehiculo): void
    {
        $this->dispatch('open-modal-activar-vehiculo', $vehiculo);
    }

    public function createMantenimiento(Vehiculos $vehiculo): void
    {
        $this->dispatch('open-modal-save-mantenimiento', from: 'vehiculos-index', vehiculo: $vehiculo);
    }

    public function abrirModalSuscripcion(Vehiculos $vehiculo): void
    {
        $this->dispatch('abrir-modal-suscripcion', vehiculoId: $vehiculo->id);
    }

    public function openModalAddVehiculo(): void
    {
        $this->dispatch('open-modal-add-vehiculo');
    }

    public function abrirSincronizarFlota(): void
    {
        $this->dispatch('abrir-sincronizar-flota');
    }

    #[On('create-mantenimiento')]
    public function openModalCreateMantenimiento($placa): void
    {
        $this->dispatch('open-modal-mantenimiento', placa: $placa);
    }

    public function exportVehiculos()
    {
        try {
            $nombre = 'vehiculos_' . Carbon::now()->format('d-m') . '.xls';

            return Excel::download(new VehiculosExport, $nombre);
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify',
                icon: 'error',
                title: 'ERROR AL EXPORTAR',
                mensaje: 'No se pudo exportar: ' . $th->getMessage(),
            );
        }
    }
}

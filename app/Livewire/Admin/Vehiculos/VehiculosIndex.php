<?php

namespace App\Livewire\Admin\Vehiculos;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Plan;
use App\Models\Sector;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Exports\VehiculosExport;
use Maatwebsite\Excel\Facades\Excel;

class VehiculosIndex extends Component
{
    use WithPagination;
    public $search;
    public $from          = '';
    public $to            = '';
    public $clientes_id   = null;
    public $marca_filter  = null;
    public ?int $plan_filter   = null;
    public ?int $sector_filter = null;

    protected $listeners = [
        'update-table' => 'render',
        'echo:vehiculos,VehiculosImportUpdated' => 'updateVehiculos'
    ];

    public function updateVehiculos()
    {
        $this->render();
        $this->dispatch('vehiculos-import');
    }

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $vehiculos = Vehiculos::query()
            ->with(['planSubscriptions', 'cobro', 'sectores'])
            ->when($this->clientes_id, function ($query) {
                $query->where('clientes_id', $this->clientes_id);
            })
            ->when($this->marca_filter, function ($query) {
                $query->where('marca', $this->marca_filter);
            })
            ->when($this->sector_filter, function ($query) {
                $query->whereHas('sectores', fn($q) => $q->where('sectores.id', $this->sector_filter));
            })
            ->when($this->plan_filter, function ($query) {
                $query->whereHas('planSubscriptions', fn($q) =>
                    $q->where('plan_id', $this->plan_filter)->whereNull('canceled_at')
                );
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('sim_card', function ($query) {
                        $query->where('sim_card', 'LIKE', '%' . $this->search . '%');
                        $query->orwhereHas('linea', function ($linea) {
                            $linea->where('numero', 'LIKE', '%' . $this->search . '%');
                        });
                    })->orwhereHas('cliente', function ($query) {
                        $query->where('razon_social', 'LIKE', '%' . $this->search . '%');
                    })->orwhereHas('dispositivosAsignados', function ($query) {
                        $query->where('dispositivos.imei', 'LIKE', '%' . $this->search . '%');
                    })->orWhere('placa', 'like', '%' . $this->search . '%')
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
            ->when(!empty($desde), function ($query) use ($desde, $hasta) {
                $query->whereRaw(
                    "(created_at >= ? AND created_at <= ?)",
                    [
                        $desde . " 00:00:00",
                        $hasta . " 23:59:59"
                    ]
                );
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        $total = Vehiculos::count();

        // Obtener marcas únicas para el filtro
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->clientes_id   = null;
        $this->marca_filter  = null;
        $this->plan_filter   = null;
        $this->sector_filter = null;
        $this->search        = '';
        $this->from          = '';
        $this->to            = '';
        $this->resetPage();
    }

    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 7 days"));
                $this->to = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 month"));
                $this->to = date('Y-m-d');
                break;
            case '12':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 year"));
                $this->to = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }

    public function openModalSave()
    {
        $this->dispatch('open-modal-save');
    }

    public function openModalEdit(Vehiculos $vehiculo)
    {
        $this->dispatch('open-modal-edit', vehiculo: $vehiculo);
    }

    public function openModalImport()
    {

        $this->dispatch('open-modal.import');
    }


    public function deleteVehiculo(Vehiculos $vehiculo)
    {
        $this->dispatch('open-modal-delete', vehiculo: $vehiculo);
    }

    public function suspendVehiculo(Vehiculos $vehiculo)
    {
        $this->dispatch('open-modal-suspend-vehiculo', $vehiculo);
    }

    public function activarVehiculo(Vehiculos $vehiculo)
    {
        $this->dispatch('open-modal-activar-vehiculo', $vehiculo);
    }

    public function createMantenimiento(Vehiculos $vehiculo)
    {
        $this->dispatch('open-modal-save-mantenimiento', from: 'vehiculos-index', vehiculo: $vehiculo);
    }

    public function abrirModalSuscripcion(Vehiculos $vehiculo): void
    {
        $this->dispatch('abrir-modal-suscripcion', vehiculoId: $vehiculo->id);
    }

    public function openModalAddVehiculo()
    {

        $this->dispatch('open-modal-add-vehiculo');
    }

    public function abrirSincronizarFlota(): void
    {
        $this->dispatch('abrir-sincronizar-flota');
    }

    //EVENTO QUE ESCUCHA DESDE LA VISTA AL CAMBIAR EL NUMERO Y ABRIR EL MODAL
    #[On('create-mantenimiento')]
    public function openModalCreateMantenimiento($placa)
    {
        $this->dispatch('open-modal-mantenimiento', placa: $placa);
    }

    public function exportVehiculos()
    {
        try {
            $nombre = 'vehiculos_' . Carbon::now()->format('d-m') . '.xls';

            return Excel::download(new VehiculosExport,  $nombre);
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

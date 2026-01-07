<?php

namespace App\Livewire\Admin\Cobros;

use Livewire\Component;
use App\Models\Cobros;
use App\Models\DetalleCobros;
use Livewire\WithPagination;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;
    public $search;
    public $estado;
    public $filtroFecha;
    public $perPage = 15;

    protected $listeners = [
        'render'
    ];
    protected $queryString = [
        'search' => ['except' => ''],
        'estado' => ['except' => ''],
        'status' => ['except' => ''],
        'filtroFecha' => ['except' => ''],
        'perPage' => ['except' => 15]

    ];

    public function render()
    {
        $hoy = Carbon::now();
        $fechaLimiteProximos = $hoy->copy()->addDays(7);

        $cobros = Cobros::query()
            ->with(['clientes.contactos', 'detalle.vehiculo'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('clientes', function ($clienteQuery) {
                        $clienteQuery->where('razon_social', 'like', '%' . $this->search . '%')
                            ->orWhereHas('contactos', function ($contacto) {
                                $contacto->where('nombre', 'like', '%' . $this->search . '%');
                            });
                    })->orWhereHas('detalle', function ($detalleQuery) {
                        $detalleQuery->whereHas('vehiculo', function ($vehiculo) {
                            $vehiculo->where('placa', 'like', '%' . $this->search . '%');
                        });
                    })->orWhere('tipo_pago', 'like', '%' . $this->search . '%')
                        ->orWhere('periodo', 'like', '%' . $this->search . '%')
                        ->orWhere('monto_unidad', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filtroFecha === 'por_vencer', function ($query) use ($hoy, $fechaLimiteProximos) {
                $query->whereHas('detalle', function ($detalleQuery) use ($hoy, $fechaLimiteProximos) {
                    $detalleQuery->where('estado', 1)
                        ->whereBetween('fecha', [$hoy->format('Y-m-d'), $fechaLimiteProximos->format('Y-m-d')]);
                });
            })
            ->when($this->filtroFecha === 'vencidos', function ($query) use ($hoy) {
                $query->whereHas('detalle', function ($detalleQuery) use ($hoy) {
                    $detalleQuery->where('estado', 1)
                        ->where('fecha', '<=', $hoy->format('Y-m-d'));
                });
            })
            ->when($this->filtroFecha === 'proximo_mes', function ($query) use ($hoy) {
                $fechaLimite = $hoy->copy()->addMonth();
                $query->whereHas('detalle', function ($detalleQuery) use ($hoy, $fechaLimite) {
                    $detalleQuery->where('estado', 1)
                        ->whereBetween('fecha', [$hoy->format('Y-m-d'), $fechaLimite->format('Y-m-d')]);
                });
            })
            ->when($this->estado, function ($query) {
                $query->where('estado', $this->estado);
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.cobros.index', compact('cobros'));
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

    public function openModalDelete(Cobros $cobro)
    {
        $this->dispatch('openModalDelete', $cobro);
    }

    public function cambiarEstado(DetalleCobros $detalleCobros)
    {
        $detalleCobros->estado = !$detalleCobros->estado;
        $detalleCobros->save();
    }

    public function createInvoice(Cobros $cobro)
    {
        $this->dispatch('open-modal-create-invoice', cobro: $cobro);
    }
}

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

    protected $listeners = [
        'render'
    ];
    protected $queryString = [
        'search' => ['except' => ''],
        'estado' => ['except' => ''],
        'status' => ['except' => '']

    ];

    public function render()
    {

        $status = $this->estado;

        $cobros = Cobros::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
            $query->orWhereHas('contactos', function ($contacto) {
                $contacto->Where('nombre', 'like', '%' . $this->search . '%');
            });
        })->orwhereHas('detalle', function ($query) {
            $query->whereHas('vehiculo', function ($vehiculo) {
                $vehiculo->where('placa', 'like', '%' . $this->search . '%');
            });
        })->orWhere('tipo_pago', 'like', '%' . $this->search . '%')
            ->orWhere('periodo', 'like', '%' . $this->search . '%')
            ->orWhere('monto_unidad', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);


        if ($status === 1) {

            $cobros = Cobros::whereHas('clientes', function ($query) {
                $query->where('razon_social', 'like', '%' . $this->search . '%');
                $query->orWhereHas('contactos', function ($contacto) {
                    $contacto->Where('nombre', 'like', '%' . $this->search . '%');
                });
            })->orwhereHas('vehiculo', function ($query) {
                $query->where('placa', 'like', '%' . $this->search . '%');
            })->orWhere('tipo_pago', 'like', '%' . $this->search . '%')
                ->orWhere('periodo', 'like', '%' . $this->search . '%')
                ->orWhere('monto_unidad', 'like', '%' . $this->search . '%')
                ->estado('1')
                ->orderBy('id', 'desc')
                ->paginate(10);
        }
        if ($status === 2) {

            $cobros = Cobros::whereHas('clientes', function ($query) {
                $query->where('razon_social', 'like', '%' . $this->search . '%');
                $query->orWhereHas('contactos', function ($contacto) {
                    $contacto->Where('nombre', 'like', '%' . $this->search . '%');
                });
            })->orwhereHas('vehiculo', function ($query) {
                $query->where('placa', 'like', '%' . $this->search . '%');
            })->orWhere('tipo_pago', 'like', '%' . $this->search . '%')
                ->orWhere('periodo', 'like', '%' . $this->search . '%')
                ->orWhere('monto_unidad', 'like', '%' . $this->search . '%')
                ->estado('2')
                ->orderBy('id', 'desc')
                ->paginate(10);
        }
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

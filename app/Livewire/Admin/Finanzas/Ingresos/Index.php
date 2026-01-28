<?php

namespace App\Livewire\Admin\Finanzas\Ingresos;

use App\Models\CashDocument;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $from = '';
    public $to = '';
    public $tipo_filter = '';

    #[On('render')]
    public function render()
    {
        $query = CashDocument::with(['cash', 'recibo.clientes', 'venta.cliente'])
            ->whereNotNull('cash_id');

        // Búsqueda por número de documento
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->whereHas('recibo', function ($subQ) {
                    $subQ->where('numero', 'like', '%' . $this->search . '%')
                        ->orWhereHas('clientes', function ($clienteQ) {
                            $clienteQ->where('razon_social', 'like', '%' . $this->search . '%');
                        });
                })->orWhereHas('venta', function ($subQ) {
                    $subQ->where('numero_comprobante', 'like', '%' . $this->search . '%')
                        ->orWhereHas('cliente', function ($clienteQ) {
                            $clienteQ->where('razon_social', 'like', '%' . $this->search . '%');
                        });
                });
            });
        }

        // Filtro por tipo
        if ($this->tipo_filter === 'RECIBO') {
            $query->whereNotNull('recibo_id');
        } elseif ($this->tipo_filter === 'VENTA') {
            $query->whereNotNull('venta_id');
        }

        // Filtro por rango de fechas
        if (!empty($this->from) && !empty($this->to)) {
            $query->where(function ($q) {
                $q->whereHas('recibo', function ($subQ) {
                    $subQ->whereBetween('fecha_emision', [$this->from, $this->to]);
                })->orWhereHas('venta', function ($subQ) {
                    $subQ->whereBetween('fecha_emision', [$this->from, $this->to]);
                });
            });
        }

        $ingresos = $query->latest('id')->paginate(10);

        return view('livewire.admin.finanzas.ingresos.index', compact('ingresos'));
    }

    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime('-7 days'));
                $this->to = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime('-1 month'));
                $this->to = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }

    public function create()
    {
        $this->dispatch('create-income');
    }

    public function edit($id)
    {
        $this->dispatch('edit-income', id: $id);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('delete-income', id: $id);
    }
}

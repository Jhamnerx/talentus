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
        $query = CashDocument::with(['cliente', 'user'])
            ->where(function ($q) {
                $q->where('numero', 'like', '%' . $this->search . '%')
                    ->orWhere('motivo', 'like', '%' . $this->search . '%')
                    ->orWhere('cliente_nombre', 'like', '%' . $this->search . '%');
            });

        if ($this->tipo_filter) {
            $query->where('tipo_comprobante', $this->tipo_filter);
        }

        if (!empty($this->from) && !empty($this->to)) {
            $query->whereBetween('fecha_emision', [$this->from, $this->to]);
        }

        $ingresos = $query->orderBy('fecha_emision', 'desc')->paginate(10);

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

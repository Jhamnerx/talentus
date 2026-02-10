<?php

namespace App\Livewire\Admin\Finanzas\Ingresos;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Payments;
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
        $query = Payments::with(['paymentable', 'destination', 'user', 'paymentMethod', 'bankAccount'])
            ->where('type_movement', 'INGRESO')
            ->whereIn('paymentable_type', [
                'App\\Models\\Ventas',
                'App\\Models\\Recibos',
                'App\\Models\\RecibosPagosVarios'
            ]);

        // Búsqueda por número de documento o cliente
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('numero', 'like', '%' . $this->search . '%')
                    ->orWhere('numero_operacion', 'like', '%' . $this->search . '%')
                    ->orWhereHas('paymentable', function ($subQ) {
                        $subQ->where('numero_comprobante', 'like', '%' . $this->search . '%')
                            ->orWhere('serie_numero', 'like', '%' . $this->search . '%')
                            ->orWhere('serie_correlativo', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filtro por tipo de documento
        if ($this->tipo_filter === 'RECIBO') {
            $query->where(function ($q) {
                $q->where('paymentable_type', 'App\\Models\\Recibos')
                    ->orWhere('paymentable_type', 'App\\Models\\RecibosPagosVarios');
            });
        } elseif ($this->tipo_filter === 'VENTA') {
            $query->where('paymentable_type', 'App\\Models\\Ventas');
        }

        // Filtro por rango de fechas
        if (!empty($this->from) && !empty($this->to)) {
            $query->whereBetween('fecha', [$this->from, $this->to]);
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

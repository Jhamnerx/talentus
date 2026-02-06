<?php

namespace App\Livewire\Admin\Finanzas\Ingresos;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\CashDocument;
use Livewire\WithPagination;
use App\Models\GlobalPayment;

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
        // En Talentus los ingresos vienen de GlobalPayment con tipo INGRESO
        $query = GlobalPayment::with(['payment.paymentable', 'destination', 'user'])
            ->whereHas('payment', function ($q) {
                // Solo mostrar ingresos (ventas y recibos)
                $q->whereIn('paymentable_type', [
                    'App\\Models\\Ventas',
                    'App\\Models\\Recibos',
                    'App\\Models\\RecibosPagosVarios'
                ]);
            });

        // Búsqueda por número de documento o cliente
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->whereHas('payment.paymentable', function ($subQ) {
                    // Buscar por número de comprobante o documento
                    $subQ->where('numero', 'like', '%' . $this->search . '%')
                        ->orWhere('numero_comprobante', 'like', '%' . $this->search . '%');
                });
            });
        }

        // Filtro por tipo de documento
        if ($this->tipo_filter === 'RECIBO') {
            $query->whereHas('payment', function ($q) {
                $q->where('paymentable_type', 'App\\Models\\Recibos')
                    ->orWhere('paymentable_type', 'App\\Models\\RecibosPagosVarios');
            });
        } elseif ($this->tipo_filter === 'VENTA') {
            $query->whereHas('payment', function ($q) {
                $q->where('paymentable_type', 'App\\Models\\Ventas');
            });
        }

        // Filtro por rango de fechas
        if (!empty($this->from) && !empty($this->to)) {
            $query->whereBetween('created_at', [$this->from, $this->to]);
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

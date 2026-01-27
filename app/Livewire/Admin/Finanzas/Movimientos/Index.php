<?php

namespace App\Livewire\Admin\Finanzas\Movimientos;

use App\Models\GlobalPayment;
use App\Models\Cash;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $from = '';
    public $to = '';
    public $payment_type = '';
    public $destination_type = '';
    public $type_movement = ''; // INGRESO o EGRESO
    public $cash_id = '';

    public function mount()
    {
        // Establecer fechas por defecto al mes actual
        $this->from = now()->startOfMonth()->format('Y-m-d');
        $this->to = now()->format('Y-m-d');
    }

    #[On('render')]
    public function render()
    {
        $query = GlobalPayment::with(['payment.paymentable.cliente', 'destination', 'user'])
            ->whereBetween('created_at', [
                $this->from ?: now()->startOfMonth(),
                $this->to ?: now()->endOfDay()
            ]);

        // Filtro por búsqueda general
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('payment.paymentable', function ($query) {
                    $query->where('numero', 'like', '%' . $this->search . '%')
                        ->orWhere('numero_comprobante', 'like', '%' . $this->search . '%');
                });
            });
        }

        // Filtro por tipo de destino (Caja o Cuenta Bancaria)
        if ($this->destination_type) {
            $query->where('destination_type', $this->destination_type);
        }

        // Filtro por caja específica
        if ($this->cash_id) {
            $query->byCash($this->cash_id);
        }

        // Filtro por tipo de movimiento (INGRESO o EGRESO)
        if ($this->type_movement === 'INGRESO') {
            $query->ingresos();
        } elseif ($this->type_movement === 'EGRESO') {
            $query->egresos();
        }

        $movimientos = $query->latest('created_at')->paginate(20);
        $cajas = Cash::where('estado', 1)->get();

        return view('livewire.admin.finanzas.movimientos.index', compact('movimientos', 'cajas'));
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
                $this->from = now()->startOfMonth()->format('Y-m-d');
                $this->to = now()->format('Y-m-d');
                break;
        }
    }
}

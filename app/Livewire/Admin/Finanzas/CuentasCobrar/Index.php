<?php

namespace App\Livewire\Admin\Finanzas\CuentasCobrar;

use App\Models\AccountReceivable;
use App\Models\Clientes;
use App\Enums\PaymentStatus;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $from = '';
    public $to = '';
    public $estado_filter = '';
    public $cliente_id = '';

    #[On('render')]
    public function render()
    {
        $query = AccountReceivable::with(['cliente'])
            ->where(function ($q) {
                $q->where('numero_documento', 'like', '%' . $this->search . '%')
                    ->orWhereHas('cliente', function ($query) {
                        $query->where('razon_social', 'like', '%' . $this->search . '%');
                    });
            });

        if ($this->estado_filter) {
            $query->where('estado', $this->estado_filter);
        }

        if ($this->cliente_id) {
            $query->where('cliente_id', $this->cliente_id);
        }

        if (!empty($this->from) && !empty($this->to)) {
            $query->whereBetween('fecha_emision', [$this->from, $this->to]);
        }

        $cuentas = $query->orderBy('fecha_emision', 'desc')->paginate(10);
        $clientes = Clientes::orderBy('razon_social')->get();

        return view('livewire.admin.finanzas.cuentas-cobrar.index', compact('cuentas', 'clientes'));
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

    public function registrarPago($id)
    {
        $this->dispatch('registrar-pago', id: $id);
    }
}

<?php

namespace App\Livewire\Admin\Finanzas\CuentasPagar;

use App\Models\AccountPayable;
use App\Models\Proveedores;
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
    public $proveedor_id = '';

    #[On('render')]
    public function render()
    {
        $query = AccountPayable::with(['proveedor'])
            ->where(function ($q) {
                $q->where('numero_documento', 'like', '%' . $this->search . '%')
                    ->orWhereHas('proveedor', function ($query) {
                        $query->where('nombre', 'like', '%' . $this->search . '%');
                    });
            });

        if ($this->estado_filter) {
            $query->where('estado', $this->estado_filter);
        }

        if ($this->proveedor_id) {
            $query->where('proveedor_id', $this->proveedor_id);
        }

        if (!empty($this->from) && !empty($this->to)) {
            $query->whereBetween('fecha_emision', [$this->from, $this->to]);
        }

        $cuentas = $query->orderBy('fecha_emision', 'desc')->paginate(10);
        $proveedores = Proveedores::orderBy('nombre')->get();

        return view('livewire.admin.finanzas.cuentas-pagar.index', compact('cuentas', 'proveedores'));
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
        $this->dispatch('registrar-pago-proveedor', id: $id);
    }
}

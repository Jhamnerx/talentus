<?php

namespace App\Livewire\Admin\Finanzas\Transacciones;

use App\Models\CashMovement;
use App\Enums\MovementType;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaccionesExport;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $from = '';
    public $to = '';
    public $tipo_filter = '';
    public $cash_id = '';

    #[On('render')]
    public function render()
    {
        $query = CashMovement::with(['cash', 'cliente', 'user'])
            ->where(function ($q) {
                $q->where('numero', 'like', '%' . $this->search . '%')
                    ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                    ->orWhereHas('cliente', function ($query) {
                        $query->where('razon_social', 'like', '%' . $this->search . '%');
                    });
            });

        if ($this->tipo_filter !== '') {
            $query->where('tipo', $this->tipo_filter);
        }

        if ($this->cash_id) {
            $query->where('cash_id', $this->cash_id);
        }

        if (!empty($this->from) && !empty($this->to)) {
            $query->whereBetween('fecha', [$this->from, $this->to]);
        }

        $movimientos = $query->orderBy('fecha', 'desc')->paginate(10);
        $cajas = \App\Models\Cash::all();

        return view('livewire.admin.finanzas.transacciones.index', compact('movimientos', 'cajas'));
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

    public function export()
    {
        return Excel::download(
            new TransaccionesExport($this->from, $this->to, $this->tipo_filter, $this->cash_id, $this->search),
            'transacciones_' . date('Y-m-d') . '.xlsx'
        );
    }
}

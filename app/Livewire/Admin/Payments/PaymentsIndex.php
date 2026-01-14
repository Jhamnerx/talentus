<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payments;
use App\Exports\PaymentsExport;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;

class PaymentsIndex extends Component
{
    use WithPagination;

    public $search;
    public $from = '';
    public $to = '';
    public $divisa = null;
    public $payment_method_id = '';

    protected $listeners = [
        'render' => 'render',
        'updateTable' => 'render',
        'update-table' => 'render',
    ];

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $payments = Payments::with(['paymentMethod', 'cobros', 'paymentable', 'user'])
            ->where(function ($query) {
                $query->where('numero', 'like', '%' . $this->search . '%')
                    ->orWhere('numero_operacion', 'like', '%' . $this->search . '%')
                    ->orWhere('documento', 'like', '%' . $this->search . '%')
                    ->orWhere('nota', 'like', '%' . $this->search . '%');
            })
            ->when(!empty($desde), function ($query) use ($desde, $hasta) {
                return $query->whereDate('fecha', '>=', $desde)
                    ->whereDate('fecha', '<=', $hasta);
            })
            ->when($this->divisa, function ($query) {
                return $query->where('divisa', $this->divisa);
            })
            ->when($this->payment_method_id, function ($query) {
                return $query->where('payment_method_id', $this->payment_method_id);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $total = Payments::when(!empty($desde), function ($query) use ($desde, $hasta) {
            return $query->whereDate('fecha', '>=', $desde)
                ->whereDate('fecha', '<=', $hasta);
        })
            ->when($this->divisa, function ($query) {
                return $query->where('divisa', $this->divisa);
            })
            ->sum('monto');

        return view('livewire.admin.payments.payments-index', compact('payments', 'total'));
    }

    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 7 days"));
                $this->to = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 month"));
                $this->to = date('Y-m-d');
                break;
            case '12':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 year"));
                $this->to = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'from', 'to', 'divisa', 'payment_method_id']);
    }

    public function editPayment($id)
    {
        $this->dispatch('open-modal-edit', id: $id);
    }

    public function deletePayment($id)
    {
        $this->dispatch('open-modal-delete', id: $id);
    }

    public function openExportModal()
    {
        $this->dispatch('open-modal-export');
    }
}

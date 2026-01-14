<?php

namespace App\Livewire\Admin\Payments;

use App\Exports\PaymentsExport;
use App\Models\PaymentMethodType;
use Livewire\Component;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use WireUi\Traits\WireUiActions;

class ExportPayments extends Component
{
    use WireUiActions;

    public $modalExport = false;
    public $payment_method_id = '';
    public $from = '';
    public $to = '';

    public function render()
    {
        $paymentMethods = PaymentMethodType::whereActive(true)->orderByDescription()->get();
        return view('livewire.admin.payments.export-payments', compact('paymentMethods'));
    }

    #[On('open-modal-export')]
    public function openModal()
    {
        $this->modalExport = true;
        // Limpiar campos al abrir
        $this->reset(['payment_method_id', 'from', 'to']);
    }

    public function closeModal()
    {
        $this->modalExport = false;
        $this->reset(['payment_method_id', 'from', 'to']);
    }

    public function exportar()
    {
        $this->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date|after_or_equal:from',
        ], [
            'to.after_or_equal' => 'La fecha final debe ser igual o posterior a la fecha inicial',
        ]);

        try {
            $filename = 'pagos_' . date('Y-m-d_His') . '.xlsx';

            $this->closeModal();

            $this->notification()->success(
                'Exportación iniciada',
                'El archivo se descargará en breve'
            );

            return Excel::download(
                new PaymentsExport('', $this->from, $this->to, null, $this->payment_method_id),
                $filename
            );
        } catch (\Throwable $th) {
            $this->notification()->error('Error', $th->getMessage());
        }
    }
}

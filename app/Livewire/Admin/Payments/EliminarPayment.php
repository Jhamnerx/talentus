<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payments;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class EliminarPayment extends Component
{
    use WireUiActions;

    public $openModalDelete = false;
    public Payments $payment;

    public function render()
    {
        return view('livewire.admin.payments.eliminar-payment');
    }

    #[On('open-modal-delete')]
    public function openModal($id)
    {
        $payment = Payments::find($id);

        if (!$payment) {
            $this->notification()->error('Error', 'Pago no encontrado');
            return;
        }

        $this->openModalDelete = true;
        $this->payment = $payment;
    }

    public function delete()
    {
        try {
            $numero = $this->payment->numero;
            $this->payment->delete();

            $this->openModalDelete = false;
            $this->notification()->success('Pago eliminado', 'El pago ' . $numero . ' fue eliminado correctamente');
            $this->dispatch('update-table');
        } catch (\Throwable $th) {
            $this->notification()->error('Error', $th->getMessage());
        }
    }
}

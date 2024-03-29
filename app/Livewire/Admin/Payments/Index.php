<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payments;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;


    public $search;
    public $PaymentOpen = false;


    public function render()
    {

        $payments = Payments::whereHas('paymentable', function ($query) {
            $query->where('serie_numero', 'LIKE', '%' . $this->search . '%');
        })->orWhere('numero', 'like', '%' . $this->search . '%')->paginate(10);

        $total = Payments::all()->sum('monto');
        return view('livewire.admin.payments.index', compact('payments', 'total'));
    }

    public function openPaymentPanel(Payments $payment)
    {

        $this->dispatch('PaymentPanel', $payment->numero);

        $this->setPaymentOpen();
    }

    public function setPaymentOpen()
    {
        $this->PaymentOpen = true;
    }

    public function setPaymentClose()
    {
        $this->PaymentOpen = false;
        sleep(5);
    }
}

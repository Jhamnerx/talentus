<?php

namespace App\Http\Livewire\Admin\Payments;

use App\Models\Payments;
use Livewire\Component;

class PaymentsPanel extends Component
{

    public $PaymentOpen = false;

    protected $listeners = [
        'PaymentPanel',
    ];

    public function render()
    {
        return view('livewire.admin.payments.payments-panel');
    }

    public function PaymentPanel(Payments $payment)
    {
        dd($payment->numero);
        $this->setPaymentOpen();
    }


    public function setPaymentOpen()
    {
        $PaymentOpen = true;
    }
}

<?php

namespace App\Http\Livewire\Admin\Payments;

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
            $query->where('numero', 'LIKE', '%' . $this->search . '%');
        })->orWhere('numero', 'like', '%' . $this->search . '%')->paginate(10);


        return view('livewire.admin.payments.index', compact('payments'));
    }




    public function openPaymentPanel(Payments $payment)
    {
        //dd($payment);
        $this->emit('PaymentPanel', $payment);
    }
}

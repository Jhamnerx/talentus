<?php

namespace App\View\Components\Admin\Payments;

use Illuminate\View\Component;

class PaymentsTable extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct(public $payments)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.payments.payments-table');
    }
}

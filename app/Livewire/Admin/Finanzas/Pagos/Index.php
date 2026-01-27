<?php

namespace App\Livewire\Admin\Finanzas\Pagos;

use Livewire\Component;

class Index extends Component
{
    // Este componente no se usa porque finanzas.pagos.index
    // redirige directamente a admin.payments.index en el controlador
    public function render()
    {
        return view('livewire.admin.finanzas.pagos.index');
    }
}

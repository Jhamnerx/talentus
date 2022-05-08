<?php

namespace App\Http\Livewire\Admin\Dispositivos;

use Livewire\Component;

class AddModeloDispositivo extends Component
{
    public $modelo, $marca, $certificado;

    public function save()
    {
        // CODIGO PARA GUARDAR LINEA
    }
    public function render()
    {
        return view('livewire.admin.dispositivos.add-modelo-dispositivo');
    }
}

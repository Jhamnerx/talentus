<?php

namespace App\Http\Livewire\Admin\GuiasRemision;

use App\Models\MotivosTraslado;
use Livewire\Component;

class Create extends Component
{
    public function render()
    {
        $motivos = MotivosTraslado::pluck('descripcion', 'codigo');
        return view('livewire.admin.guias-remision.create', compact('motivos'));
    }
}

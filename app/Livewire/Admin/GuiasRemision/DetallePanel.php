<?php

namespace App\Livewire\Admin\GuiasRemision;

use App\Models\GuiaRemision;
use Livewire\Component;

class DetallePanel extends Component
{
    public GuiaRemision $guia;

    protected $listeners = [
        'DetallePanel',
    ];

    public function DetallePanel(GuiaRemision $guia)
    {

        $this->guia = $guia;
    }
    public function render()
    {
        return view('livewire.admin.guias-remision.detalle-panel');
    }
}

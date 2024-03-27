<?php

namespace App\Livewire\Admin\GuiasRemision;

use App\Models\GuiaRemision;
use Livewire\Attributes\On;
use Livewire\Component;

class DetallePanel extends Component
{
    public GuiaRemision $guia;
    public $detallePanelOpen = false;

    #[On('open-detalle-panel')]
    public function openDetallePanel(GuiaRemision $guia)
    {

        $this->guia = $guia;
        $this->detallePanelOpen = true;
    }


    public function render()
    {
        return view('livewire.admin.guias-remision.detalle-panel');
    }

    public function closeDetallePanel()
    {
        $this->detallePanelOpen = false;
    }
}

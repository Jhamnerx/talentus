<?php

namespace App\Livewire\Admin\GuiasRemision;

use App\Models\GuiaRemision;
use Livewire\Component;

class EliminarGuiaRemision extends Component
{
    public GuiaRemision $guia;
    public $mostrarModal = false;

    protected $listeners = [
        'EliminarGuia' => 'abrirModal',
    ];

    public function abrirModal(GuiaRemision $guia)
    {
        $this->mostrarModal = true;
        $this->guia = $guia;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

    public function eliminar()
    {
        $this->guia->delete();
        $this->dispatch('guia-delete', ['delete' => $this->guia]);
        $this->dispatch('updateTable');
    }

    public function render()
    {
        return view('livewire.admin.guias-remision.eliminar-guia-remision');
    }
}

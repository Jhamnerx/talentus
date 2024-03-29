<?php

namespace App\Livewire\Admin\GuiasRemision;

use App\Models\GuiaRemision;
use Livewire\Component;

class Delete extends Component
{
    public GuiaRemision $guia;

    public $modalDelete = false;

    protected $listeners = [
        'EliminarGuia' => 'openModal',
    ];

    public function delete()
    {
        $this->guia->delete();
        // return redirect()->route('admin.vehiculos.index');
        $this->dispatch('guia-delete', ['delete' => $this->guia]);

        $this->dispatch('updateTable');
    }


    public function openModal(GuiaRemision $guia)
    {
        $this->modalDelete = true;
        $this->guia = $guia;
    }

    public function render()
    {
        return view('livewire.admin.guias-remision.delete');
    }
}

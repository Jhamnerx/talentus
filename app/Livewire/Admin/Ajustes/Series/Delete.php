<?php

namespace App\Livewire\Admin\Ajustes\Series;

use App\Models\Series;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{

    public $modalDelete = false;
    public Series $serie;

    public function render()
    {
        return view('livewire.admin.ajustes.series.delete');
    }

    #[On('delete-serie')]
    public function openModal(Series $serie)
    {
        $this->modalDelete = true;
        $this->serie = $serie;
    }

    public function delete()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            tittle: 'SERIE ELIMINADA',
            mensaje: 'La serie: ' . $this->serie->serie . ' de ' . $this->serie->tipoComprobante->descripcion . ' fue eliminada',
        );

        $this->serie->delete();

        $this->dispatch('update-table');
    }
}

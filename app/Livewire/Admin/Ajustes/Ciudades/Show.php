<?php

namespace App\Livewire\Admin\Ajustes\Ciudades;

use App\Models\Ciudades;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{

    use WithPagination;
    public $search = '';

    protected $listeners = [
        'render'
    ];

    public function render()
    {
        $ciudades = Ciudades::where('nombre', 'like', '%' . $this->search . '%')->paginate(5);

        return view('livewire.admin.ajustes.ciudades.show', compact('ciudades'));
    }

    public function openModalSave()
    {
        $this->dispatch('openModalSave');
    }


    public function openModalEdit(Ciudades $ciudad)
    {
        $this->dispatch('openModalEdit', $ciudad);
    }
    public function openModalDelete(Ciudades $ciudad)
    {

        $this->dispatch('openModalDelete', $ciudad);
    }
}

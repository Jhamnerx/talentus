<?php

namespace App\Livewire\Admin\SimCard;

use Livewire\Component;

class Index extends Component
{

    protected $listeners = [
        'render' => 'render',
        'echo:sim,SimCardImportUpdated' => 'updateSimCard'
    ];

    public function updateSimCard()
    {
        $this->render();
        $this->dispatch('sim-import');
    }

    public function render()
    {

        return view('livewire.admin.sim-card.index');
    }

    public function openModalImport()
    {
        $this->dispatch('open-modal-import');
    }

    public function openModalCreate()
    {
        $this->dispatch('open-modal-create');
    }

    public function openModalAsign()
    {
        $this->dispatch('open-modal-asign');
    }
}

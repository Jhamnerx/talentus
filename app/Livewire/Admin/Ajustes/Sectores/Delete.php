<?php

namespace App\Livewire\Admin\Ajustes\Sectores;

use App\Models\Sector;
use Livewire\Component;

class Delete extends Component
{
    public bool    $openModal = false;
    public ?Sector $sector    = null;

    protected $listeners = ['openModalDeleteSector' => 'open'];

    public function open(Sector $sector): void
    {
        $this->sector    = $sector;
        $this->openModal = true;
    }

    public function close(): void
    {
        $this->openModal = false;
        $this->sector    = null;
    }

    public function delete(): void
    {
        $nombre = $this->sector->nombre;
        $this->sector->delete();

        $this->dispatch('notify-toast', icon: 'success', title: 'SECTOR ELIMINADO', mensaje: 'Se eliminó el sector: ' . $nombre);
        $this->dispatch('update-table');
        $this->close();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.sectores.delete');
    }
}

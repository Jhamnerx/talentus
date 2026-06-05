<?php

namespace App\Livewire\Admin\Ajustes\Rubros;

use App\Models\RubroCliente;
use Livewire\Component;

class Delete extends Component
{
    public bool          $openModal = false;
    public ?RubroCliente $rubro     = null;

    protected $listeners = ['openModalDeleteRubro' => 'open'];

    public function open(RubroCliente $rubro): void
    {
        $this->rubro     = $rubro;
        $this->openModal = true;
    }

    public function close(): void
    {
        $this->openModal = false;
        $this->rubro     = null;
    }

    public function delete(): void
    {
        $nombre = $this->rubro->nombre;
        $this->rubro->delete();

        $this->dispatch('notify-toast', icon: 'success', title: 'RUBRO ELIMINADO', mensaje: 'Se eliminó el rubro: ' . $nombre);
        $this->dispatch('update-table');
        $this->close();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.rubros.delete');
    }
}

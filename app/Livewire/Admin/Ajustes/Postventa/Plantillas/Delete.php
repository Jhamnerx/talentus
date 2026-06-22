<?php

namespace App\Livewire\Admin\Ajustes\Postventa\Plantillas;

use App\Models\PostventaPlantilla;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Delete extends Component
{
    public bool                $openModal = false;
    public ?PostventaPlantilla $plantilla = null;

    protected $listeners = ['openModalDeletePlantilla' => 'open'];

    public function open(int $id): void
    {
        $this->plantilla = PostventaPlantilla::findOrFail($id);
        $this->openModal = true;
    }

    public function close(): void
    {
        $this->openModal = false;
        $this->plantilla = null;
    }

    public function delete(): void
    {
        if ($this->plantilla->archivo_url) {
            Storage::disk('public')->delete(ltrim(str_replace('/storage/', '', $this->plantilla->archivo_url), '/'));
        }

        $this->plantilla->delete();

        $this->dispatch('notify-toast', icon: 'success', title: 'PLANTILLA ELIMINADA', mensaje: 'La plantilla fue eliminada.');
        $this->dispatch('update-table');
        $this->close();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.postventa.plantillas.delete');
    }
}

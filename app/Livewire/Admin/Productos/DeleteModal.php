<?php

namespace App\Livewire\Admin\Productos;

use Livewire\Component;
use App\Models\Productos;
use Livewire\Attributes\On;

class DeleteModal extends Component
{
    public ?Productos $producto = null;

    public function render()
    {
        return view('livewire.admin.productos.delete-modal');
    }

    #[On('open-modal-delete')]
    public function openModal(Productos $producto): void
    {
        $this->producto = $producto;
        // Disparar la apertura vía Alpine (no via wire:model) para evitar
        // que el morph de Livewire coincida con toggleScrollbar de WireUI
        $this->dispatch('do-open-delete-modal');
    }

    public function closeModal(): void
    {
        $this->producto = null;
        $this->dispatch('do-close-delete-modal');
    }

    public function delete(): void
    {
        $this->producto->delete();
        $this->afterDelete();
    }

    public function afterDelete(): void
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'PRODUCTO ELIMINADO',
            mensaje: 'Se eliminó correctamente el producto'
        );

        $this->closeModal();
        $this->dispatch('update-table');
    }
}

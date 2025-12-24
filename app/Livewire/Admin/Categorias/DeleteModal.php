<?php

namespace App\Livewire\Admin\Categorias;

use Exception;
use Livewire\Component;
use App\Models\Categoria;
use Livewire\Attributes\On;

class DeleteModal extends Component
{
    public $modalDelete = false;
    public ?Categoria $categoria = null;

    public function render()
    {
        return view('livewire.admin.categorias.delete-modal');
    }

    #[On('open-modal-delete')]
    public function openModal(Categoria $categoria)
    {
        $this->categoria = $categoria;
        $this->modalDelete = true;
    }

    public function closeModal()
    {
        $this->modalDelete = false;
        $this->categoria = null;
    }

    public function delete()
    {
        try {
            if ($this->categoria->productos->count() > 0) {
                throw new Exception("La categoria contiene productos", 1);
            }

            $this->categoria->delete();
            $this->closeModal();
            $this->notification()->success(
                title: 'CATEGORIA ELIMINADA',
                description: 'Se eliminó correctamente la categoría'
            );
            $this->dispatch('categoria-saved');
        } catch (Exception $th) {
            $this->notification()->error(
                title: 'ERROR',
                description: $th->getMessage()
            );
        }
    }
}

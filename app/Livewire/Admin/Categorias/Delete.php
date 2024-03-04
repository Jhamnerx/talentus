<?php

namespace App\Livewire\Admin\Categorias;

use Livewire\Component;
use App\Models\Categoria;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Model;

class Delete extends Component
{
    public Categoria $categoria;

    public $modalDelete = false;

    public function delete()
    {
        $this->categoria->delete();
        $this->afterDelete();
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
    }

    public function afterDelete()
    {
        $this->closeModal();
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'CATEGORIA ELIMINADA',
            mensaje: 'se elimino correctamente la categoria'
        );
        $this->dispatch('update-table');
    }


    public function render()
    {
        return view('livewire.admin.categorias.delete');
    }
}

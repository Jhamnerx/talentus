<?php

namespace App\Livewire\Admin\Categorias;

use Exception;
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
        try {

            if ($this->categoria->productos->count() > 0) {
                return throw new Exception("La categoria contiene productos", 1);
            }

            $this->categoria->delete();
            $this->afterDelete();
        } catch (Exception $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: $th->getMessage(),
            );
        }
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
        $this->dispatch('pg:eventRefresh-TablaCategorias');
    }


    public function render()
    {
        return view('livewire.admin.categorias.delete');
    }
}

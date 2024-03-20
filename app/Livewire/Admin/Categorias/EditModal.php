<?php

namespace App\Livewire\Admin\Categorias;

use Livewire\Component;
use App\Models\Categoria;
use Livewire\Attributes\On;
use App\Http\Requests\CategoriaRequest;

class EditModal extends Component
{
    public $modalEdit = false;

    public $nombre, $descripcion;
    public Categoria $categoria;


    public function render()
    {
        return view('livewire.admin.categorias.edit-modal');
    }

    #[On('open-modal-edit')]
    public function openModal(Categoria $categoria)
    {
        $this->categoria = $categoria;
        $this->nombre = $categoria->nombre;
        $this->descripcion = $categoria->descripcion;
        $this->modalEdit = true;
    }

    public function closeModal()
    {

        $this->modalEdit = false;
    }

    public function save()
    {
        $request = new CategoriaRequest();
        $datos = $this->validate($request->rules($this->categoria), $request->messages());

        try {
            $this->categoria->update($datos);
            $this->afterSave($this->categoria);
        } catch (\Throwable $th) {

            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function afterSave($categoria)
    {
        $this->closeModal();
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'CATEGORIA ACTUALIZADA',
            mensaje: 'La Categoria ' . $categoria->nombre . ' fue actualizada correctamente'
        );
        $this->dispatch('update-table');
        $this->resetProp();
    }
    public function resetProp()
    {
        $this->reset(['nombre', 'descripcion']);
    }
}

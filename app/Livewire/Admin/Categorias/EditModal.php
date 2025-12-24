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
    public ?Categoria $categoria = null;

    public function render()
    {
        return view('livewire.admin.categorias.edit-modal');
    }

    #[On('open-modal-edit')]
    public function openModal(Categoria $categoria)
    {
        $this->resetValidation();
        $this->categoria = $categoria;
        $this->nombre = $categoria->nombre;
        $this->descripcion = $categoria->descripcion;
        $this->modalEdit = true;
    }

    public function closeModal()
    {
        $this->modalEdit = false;
        $this->resetProp();
    }

    public function update()
    {
        $request = new CategoriaRequest();
        $datos = $this->validate($request->rules($this->categoria), $request->messages());

        try {
            $this->categoria->update($datos);
            $this->closeModal();
            $this->notification()->success(
                title: 'CATEGORIA ACTUALIZADA',
                description: 'La Categoria ' . $this->categoria->nombre . ' fue actualizada correctamente'
            );
            $this->dispatch('categoria-saved');
            $this->resetProp();
        } catch (\Throwable $th) {
            $this->notification()->error(
                title: 'ERROR',
                description: $th->getMessage()
            );
        }
    }

    public function resetProp()
    {
        $this->reset(['nombre', 'descripcion', 'categoria']);
    }
}

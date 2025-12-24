<?php

namespace App\Livewire\Admin\Categorias;

use Livewire\Component;
use App\Models\Categoria;
use Livewire\Attributes\On;
use App\Http\Requests\CategoriaRequest;

class CreateModal extends Component
{
    public $modalCreate = false;
    public $nombre, $descripcion;

    public function render()
    {
        return view('livewire.admin.categorias.create-modal');
    }

    #[On('open-modal-create')]
    public function openModal()
    {

        $this->resetValidation();
        $this->resetProp();
        $this->modalCreate = true;
    }

    public function closeModal()
    {
        $this->modalCreate = false;
        $this->resetProp();
    }

    public function save()
    {
        $request = new CategoriaRequest();
        $datos = $this->validate($request->rules(), $request->messages());

        try {
            $categoria = Categoria::create($datos);
            $this->closeModal();
            $this->notification()->success(
                title: 'CATEGORIA REGISTRADA',
                description: 'La Categoria ' . $categoria->nombre . ' fue guardada correctamente'
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
        $this->reset(['nombre', 'descripcion']);
    }
}

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
        $this->modalCreate = true;
    }
    public function closeModal()
    {

        $this->modalCreate = false;
    }


    public function save()
    {
        $request = new CategoriaRequest();
        $datos = $this->validate($request->rules(), $request->messages());

        try {
            $categoria = Categoria::create($datos);
            $this->afterSave($categoria);
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
            'notify',
            icon: 'success',
            title: 'CATEGORIA REGISTRADA',
            mensaje: 'La Categoria ' . $categoria->nombre . ' fue guardada correctamente'
        );
        $this->dispatch('update-table');
        $this->resetProp();
    }

    public function resetProp()
    {
        $this->reset(['nombre', 'descripcion']);
    }
}

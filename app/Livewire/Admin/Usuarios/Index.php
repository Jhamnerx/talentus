<?php

namespace App\Livewire\Admin\Usuarios;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search;

    #[\Livewire\Attributes\On('update-table')]
    public function updateTable()
    {
        $this->render();
    }

    public function render()
    {
        $usuarios = User::Where('name', 'like', '%' . $this->search . '%')
            ->excludeEmail('jhamnerx1x@gmail.com')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $total = User::all()->count() - 1;
        return view('livewire.admin.usuarios.index', compact('usuarios', 'total'));
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active; // Cambia el estado del toggle
        $user->save(); // Guarda el cambio en el modelo
    }

    public function openModalCreate()
    {
        $this->dispatch('open-modal-create');
    }

    public function openModalEdit(User $usuario)
    {

        $this->dispatch('open-modal-edit', usuario: $usuario);
    }
}

<?php

namespace App\Livewire\Admin\Categorias;

use Livewire\Component;
use App\Models\Categoria;
use Livewire\WithPagination;
use Illuminate\Support\Collection;

class Index extends Component
{
    use WithPagination;

    public $search;
    public $sort = "id";
    public $direction = "desc";
    public Collection $selected;

    public function mount()
    {

        $this->selected = collect();
    }
    public function render()
    {
        $categorias = Categoria::where(function ($query) {
            $query->where('descripcion', 'like', '%' . $this->search . '%')
                ->orwhere('nombre', 'like', '%' . $this->search . '%');
        })->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.categorias.index', compact('categorias'));
    }

    #[\Livewire\Attributes\On('update-table')]
    public function updateTable()
    {
        $this->render();
    }

    public function openModalCreate()
    {

        $this->dispatch('open-modal-create');
    }

    public function openModalDelete(Categoria $categoria)
    {

        $this->dispatch('open-modal-delete', categoria: $categoria);
    }

    public function openModalEdit(Categoria $categoria)
    {
        $this->dispatch('open-modal-edit', categoria: $categoria);
    }

    public function deleteSelected()
    {
        $categorias = Categoria::findMany($this->selected);
        $categorias->map->delete();
        $this->selected = collect();
        $this->render();
    }

    public function toggleStatus(Categoria $categoria)
    {
        $categoria->estado = !$categoria->estado; // Cambia el estado del toggle
        $categoria->save(); // Guarda el cambio en el modelo
    }
}

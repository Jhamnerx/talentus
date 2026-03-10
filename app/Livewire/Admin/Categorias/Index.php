<?php

namespace App\Livewire\Admin\Categorias;

use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $estadoFilter = '';
    public $perPage = 10;

    public function render()
    {
        $categorias = Categoria::query()
            ->when($this->search, function ($query) {
                $query->where('descripcion', 'like', '%' . $this->search . '%')
                    ->orWhere('nombre', 'like', '%' . $this->search . '%');
            })
            ->when($this->estadoFilter !== '', function ($query) {
                $query->where('estado', $this->estadoFilter);
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.categorias.index', compact('categorias'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingEstadoFilter()
    {
        $this->resetPage();
    }

    #[On('categoria-saved')]
    public function refreshTable()
    {
        $this->render();
    }

    // ============ MODAL CREATE ============
    public function openModalCreate()
    {
        $this->dispatch('open-modal-create');
    }

    // ============ MODAL EDIT ============
    public function openModalEdit(Categoria $categoria)
    {
        $this->dispatch('open-modal-edit', categoria: $categoria);
    }

    // ============ MODAL DELETE ============
    public function openModalDelete(Categoria $categoria)
    {
        $this->dispatch('open-modal-delete', categoria: $categoria);
    }

    // ============ TOGGLE STATUS ============
    public function toggleStatus(int $id): void
    {
        $this->authorize('cambiar.estado-categoria');
        $categoria = Categoria::findOrFail($id);
        $categoria->estado = ! $categoria->estado;
        $categoria->save();
    }
}

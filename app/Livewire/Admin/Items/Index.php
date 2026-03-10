<?php

namespace App\Livewire\Admin\Items;

use Livewire\Component;
use App\Models\Productos;

use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $estadoFilter = '';
    public $categoriaFilter = '';
    public $tipoFilter = '';
    public $tipo = null;

    public function render()
    {
        $productos = Productos::query()
            ->with('image', 'categoria', 'unit')
            ->when($this->tipo, function ($query) {
                $query->where('tipo', $this->tipo);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('codigo', 'like', '%' . $this->search . '%')
                        ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                        ->orWhere('valor_unitario', 'like', '%' . $this->search . '%')
                        ->orWhere('tipo', 'like', '%' . $this->search . '%')
                        ->orWhereHas('categoria', function ($query) {
                            $query->where('nombre', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->estadoFilter !== '', function ($query) {
                $query->where('estado', $this->estadoFilter);
            })
            ->when($this->categoriaFilter, function ($query) {
                $query->where('categoria_id', $this->categoriaFilter);
            })
            ->when($this->tipoFilter, function ($query) {
                $query->where('tipo', $this->tipoFilter);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $categorias = \App\Models\Categoria::where('estado', 1)->orderBy('nombre')->get();

        return view('livewire.admin.items.productos-index', compact('productos', 'categorias'));
    }

    public function openModalCreate()
    {
        $this->dispatch('open-modal-create', tipo: $this->tipo);
    }

    public function openModalEdit(Productos $producto)
    {
        $this->dispatch('open-modal-edit', producto: $producto);
    }

    public function openModalDelete(Productos $producto)
    {
        $this->dispatch('open-modal-delete', producto: $producto);
    }

    #[On('update-table')]
    public function updateTable(): void
    {
        // re-render automático al disparar el evento
    }

    // ============ TOGGLE STATUS ============
    public function toggleStatus(int $id): void
    {

        $this->authorize('cambiar.estado-producto');

        $producto = Productos::findOrFail($id);
        $producto->estado = ! $producto->estado;
        $producto->save();
    }
}

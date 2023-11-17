<?php

namespace App\Livewire\Admin\Productos;

use Livewire\Component;
use App\Models\Productos;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Netflie\WhatsAppCloudApi\WebHook\Notification\Support\Products;

class ProductosIndex extends Component
{
    use WithPagination;
    public $search;

    public function render()
    {

        $productos = Productos::whereHas('categoria', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->orWhere('unit_code', 'like', '%' . $this->search . '%')
            ->orWhere('descripcion', 'like', '%' . $this->search . '%')
            ->orWhere('valor_unitario', 'like', '%' . $this->search . '%')
            ->orWhere('tipo', 'like', '%' . $this->search . '%')
            ->with('image', 'categoria', 'unit')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.productos.productos-index', compact('productos'));
    }

    public function openModalCreate()
    {
        $this->dispatch('open-modal-create');
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
    public function updateTable()
    {
        $this->render();
    }
}

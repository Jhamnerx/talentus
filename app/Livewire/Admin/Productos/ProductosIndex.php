<?php

namespace App\Livewire\Admin\Productos;

use App\Models\Productos;
use Livewire\Component;
use Livewire\WithPagination;

class ProductosIndex extends Component
{
    use WithPagination;
    public $search;

    public function render()
    {

        $productos = Productos::whereHas('categoria', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })->orWhere('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->orWhere('unit_code', 'like', '%' . $this->search . '%')
            ->orWhere('descripcion', 'like', '%' . $this->search . '%')
            ->orWhere('tipo', 'like', '%' . $this->search . '%')
            ->with('image', 'categoria')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.productos.productos-index', compact('productos'));
    }
}

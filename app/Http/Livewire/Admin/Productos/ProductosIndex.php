<?php

namespace App\Http\Livewire\Admin\Productos;

use App\Models\Productos;
use Livewire\Component;

class ProductosIndex extends Component
{
    public $search;

    public function render()
    {

       $productos = Productos::whereHas('categoria', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })->orWhere('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        // $productos = Productos::paginate(10);

        return view('livewire.admin.productos.productos-index', compact('productos'));
    }
}

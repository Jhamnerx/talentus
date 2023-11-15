<?php

namespace App\Livewire\Admin;

use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriasIndex extends Component
{
    use WithPagination;

    public $search;
    public $sort = "id";
    public $direction = "desc";

    public function render()
    {
        $categorias = Categoria::where(function ($query) {
            $query->where('descripcion', 'like', '%' . $this->search . '%')
                ->orwhere('nombre', 'like', '%' . $this->search . '%');
        })->orderBy('id', 'desc')
            ->paginate(10);
        // ->get();

        $total = Categoria::all()->count();
        return view('livewire.admin.categorias-index', compact('categorias', 'total'));
    }
}

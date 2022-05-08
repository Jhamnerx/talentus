<?php

namespace App\Http\Livewire\Admin\Productos;

use App\Models\Productos;
use Livewire\Component;

class ProductosIndex extends Component
{
    public $search;

    public function render()
    {


        $empresa_id = session('empresa');

        // public function posts($isWithScope=true)
        // {
        //     if($isWithScope)
        //         return $this->hasMany('App\Post');
        //     else
        //         return $this->hasMany('App\Post')->withoutGlobalScope(PostScopeClass::class);
        // }
        // entonces utilízalo Categories::posts->get();yCategories::posts(false)->get();

        $productos = Productos::whereHas('categoria', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })->orWhere('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->paginate(10);

        // $productos = Productos::paginate(10);

        return view('livewire.admin.productos.productos-index', compact('productos'));
    }
}

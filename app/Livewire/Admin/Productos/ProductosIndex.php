<?php

namespace App\Livewire\Admin\Productos;

use Livewire\Component;

class ProductosIndex extends Component
{
    public $search;

    public function render()
    {
        return view('livewire.admin.productos.productos-index');
    }

    public function openModalCreate()
    {
        $this->dispatch('open-modal-create');
    }
}

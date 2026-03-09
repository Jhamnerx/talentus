<?php

namespace App\Livewire\Admin\Productos;

use Livewire\Component;
use App\Models\Productos;
use WireUi\Traits\WireUiActions;

class DeleteModal extends Component
{
    use WireUiActions;
    public function render()
    {
        return view('livewire.admin.productos.delete-modal');
    }

    public function delete(int $id): void
    {
        $producto = Productos::findOrFail($id);
        $producto->delete();

        $this->notification()->success('Producto eliminado', 'El producto ha sido eliminado correctamente.');

        $this->dispatch('update-table');
    }
}

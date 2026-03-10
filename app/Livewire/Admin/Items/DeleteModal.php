<?php

namespace App\Livewire\Admin\Items;

use Livewire\Component;
use App\Models\Productos;
use WireUi\Traits\WireUiActions;

class DeleteModal extends Component
{
    use WireUiActions;
    public function render()
    {
        return view('livewire.admin.items.delete-modal');
    }

    public function delete(int $id): void
    {
        $producto = Productos::findOrFail($id);

        if ($producto->es_servicio_cobro) {
            $this->notification()->error(
                'No se puede eliminar',
                'Este servicio está vinculado a la facturación de cobros. Desvinculalo primero desde Editar.'
            );
            return;
        }

        $producto->delete();

        $this->notification()->success('Producto eliminado', 'El producto ha sido eliminado correctamente.');

        $this->dispatch('update-table');
    }
}

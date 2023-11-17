<?php

namespace App\Livewire\Admin\Productos;

use App\Models\Productos;
use Livewire\Component;
use Livewire\Attributes\On;

class EditModal extends Component
{
    public $modalEdit = false;

    public Productos $producto;

    public $descripcion, $categoria_id, $codigo, $unit_code = "NIU",
        $stock = 1,  $valor_unitario = 0.00, $divisa = 'PEN',
        $tipo = 'producto';
    public $afecto_icbper = false;
    public $file;
    public $file_name;

    public function render()
    {
        return view('livewire.admin.productos.edit-modal');
    }

    #[On('open-modal-edit')]
    public function openModal(Productos $producto)
    {
        $this->modalEdit = true;

        $this->producto = $producto;
        $this->descripcion = $producto->descripcion;
        $this->categoria_id = $producto->categoria_id;
        $this->codigo = $producto->codigo;
        $this->unit_code = $producto->unit_code;
        $this->afecto_icbper = $producto->afecto_icbper;
        $this->divisa = $producto->divisa;
        $this->tipo = $producto->tipo;
        $this->afecto_icbper = $producto->afecto_icbper;
        $this->stock = $producto->stock;
        $this->valor_unitario = $producto->valor_unitario;

        if ($producto->image) {
            $this->dispatchBrowserEvent('set-imagen-file', ['imagen' => Storage::url($producto->image->url)]);
        } else {
            //$this->dispatchBrowserEvent('set-imagen-file', ['imagen' => Storage::url('public/productos/default.jpg')]);
        }
    }
    public function closeModal()
    {
        $this->modalEdit = false;
    }
}

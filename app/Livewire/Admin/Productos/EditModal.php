<?php

namespace App\Livewire\Admin\Productos;

use Livewire\Component;
use App\Models\Productos;
use Livewire\Attributes\On;
use App\Http\Requests\ProductosRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

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

    public function updatedCategoriaId($value)
    {
        $this->generateCodeProduct($value);
    }

    public function generateCodeProduct($categoria_id)
    {
        $producto =  Productos::where('categoria_id', $categoria_id)->latest()->first();

        $this->codigo = $producto ? 'PROD-' . $categoria_id . str_replace('PROD-', '', $producto["codigo"]) + 1 : $categoria_id . "000";
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
            $this->dispatch('set-imagen-file', imagen: Storage::url($producto->image->url));
        } else {
            //$this->dispatchBrowserEvent('set-imagen-file', ['imagen' => Storage::url('public/productos/default.jpg')]);
        }
    }
    public function save()
    {
        //GUARDAR PRODUCTO
        $request = new ProductosRequest();

        $datos = $this->validate($request->rules($this->producto));

        $this->producto->update($datos);

        //save imagen
        if ($this->file) {

            $this->saveImage($this->producto);
        } else {

            $this->removeImage($this->producto);
        }

        $this->afterUpdate();
    }

    public function saveImage(Productos $producto): bool
    {

        if ($this->file_name != "default.jpg") {

            $img = Image::make($this->file)->encode('jpg');
            $url = 'productos/' . $producto->codigo . '.png';
            Storage::disk('public')->put($url, $img);

            $producto->image()->create([
                'url' => $url
            ]);
        }

        return true;
    }

    public function removeImage(Productos $producto)
    {
        if ($producto->image) {
            Storage::delete($producto->image->url);
            $producto->image()->delete();
        }
    }

    public function updated($atributo)
    {

        $request = new ProductosRequest();
        $this->validateOnly($atributo, $request->rules($this->producto));
    }
    public function afterUpdate()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            tittle: 'PRODUCTO ACTUALIZADO',
            mensaje: 'se guardo correctamente el producto o servicio'
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
    public function closeModal()
    {
        $this->modalEdit = false;
    }
}

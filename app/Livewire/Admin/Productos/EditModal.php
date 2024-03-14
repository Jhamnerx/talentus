<?php

namespace App\Livewire\Admin\Productos;

use Livewire\Component;
use App\Models\Productos;
use Livewire\Attributes\On;
use Intervention\Image\ImageManager;
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

    // Generar el código del producto
    public function generateCodeProduct($categoria_id)
    {
        if ($categoria_id != $this->producto->categoria_id) {
            $lastProduct = Productos::where('categoria_id', $categoria_id)->latest('id')->withTrashed()->first();
            $lastCode = $lastProduct ? $lastProduct->codigo : 'PROD-' . $categoria_id . '000';
            $lastNumber = intval(substr($lastCode, -4));
            $newNumber = $lastNumber + 1;
            $newCode = 'PROD-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            $this->codigo = $newCode;
        } else {

            $this->codigo = $this->producto->codigo;
        }
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


        try {
            $this->producto->update($datos);

            //save imagen
            if ($this->file) {

                $this->saveImage($this->producto);
            } else {

                $this->removeImage($this->producto);
            }

            $this->afterUpdate();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function saveImage(Productos $producto): bool
    {

        if ($this->file_name != "default.jpg") {

            //$img = Image::make($this->file)->encode('jpg');
            $url = 'productos/' . $producto->codigo . '.png';
            Storage::disk('public')->put($url, $this->resizeImagen($this->file));

            $producto->image()->create([
                'url' => $url
            ]);
        }

        return true;
    }

    public static function resizeImagen($img)
    {
        // create new image manager with gd driver
        $manager = ImageManager::gd();

        $image = $manager->read($img);

        //$image->scale(height: 800);
        // $image->resize(400, 400);

        return $image->encode();
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
            title: 'PRODUCTO ACTUALIZADO',
            mensaje: 'se guardo correctamente el producto o servicio'
        );
        $this->closeModal();
        $this->resetProps();
        $this->reset('file');
        $this->dispatch('update-table');
    }
    public function closeModal()
    {
        $this->modalEdit = false;
    }
    public function resetProps()
    {
        $this->reset('descripcion', 'categoria_id', 'codigo', 'unit_code', 'stock', 'valor_unitario', 'divisa', 'tipo', 'afecto_icbper');
    }
}

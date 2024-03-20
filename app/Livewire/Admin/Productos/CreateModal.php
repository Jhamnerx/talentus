<?php

namespace App\Livewire\Admin\Productos;

use Livewire\Component;
use App\Models\Productos;
use Livewire\Attributes\On;
use Intervention\Image\ImageManager;
use App\Http\Requests\ProductosRequest;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class CreateModal extends Component
{
    public $modalCreate = false;

    public $descripcion, $categoria_id, $codigo, $unit_code = "NIU",
        $stock = 1,  $valor_unitario = 0.00, $ventas = 0, $divisa = 'PEN',
        $tipo = '';
    public $afecto_icbper = false;
    public $file;

    public $modelo_id = null;

    public function render()
    {
        return view('livewire.admin.productos.create-modal');
    }

    #[On('open-modal-create')]
    public function openModal()
    {
        $this->modalCreate = true;
    }
    public function closeModal()
    {
        $this->modalCreate = false;
    }
    public function updatedCategoriaId($value)
    {
        $this->generateCodeProduct($value);


        if ($value != 1) {
            $this->modelo_id = null;
        }
    }

    // Generar el código del producto
    public function generateCodeProduct($categoria_id)
    {
        $lastProduct = Productos::where('categoria_id', $categoria_id)->latest('id')->withTrashed()->first();
        $lastCode = $lastProduct ? $lastProduct->codigo : 'PROD-' . $categoria_id . '000';
        $lastNumber = intval(substr($lastCode, -4));
        $newNumber = $lastNumber + 1;
        $newCode = 'PROD-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        $this->codigo = $newCode;
    }

    public function save()
    {
        //GUARDAR PRODUCTO
        $request = new ProductosRequest();
        $datos = $this->validate($request->rules(), $request->messages());

        try {
            $producto = Productos::create($datos);
            //save imagen
            if ($this->file) {
                $this->saveImage($producto);
            }

            $this->afterSave();
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
        $url = 'public/productos/' . $producto->codigo . '.png';
        Storage::disk('public')->put($url, $this->resizeImagen($this->file), 'public');

        $producto->image()->create([
            'url' => $url
        ]);

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

    public function updated($atributo, $value)
    {

        $request = new ProductosRequest();
        $this->validateOnly($atributo, $request->rules(), $request->messages());
    }




    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'PRODUCTO REGISTRADO',
            mensaje: 'se guardo correctamente el producto o servicio'
        );
        $this->closeModal();
        $this->resetProps();
        $this->reset('file');
        $this->dispatch('update-table');
    }

    public function resetProps()
    {
        $this->reset('descripcion', 'categoria_id', 'codigo', 'unit_code', 'stock', 'valor_unitario', 'ventas', 'divisa', 'tipo', 'afecto_icbper');
    }
}

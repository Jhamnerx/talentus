<?php

namespace App\Livewire\Admin\Items;

use Livewire\Component;
use App\Models\plantilla;
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

    public $precio_unitario = 0.00;
    public $afecto_icbper = false;
    public $es_servicio_cobro = false;
    public $es_dispositivo = false;
    public $file;

    public $file_name;

    public $modelo_id = null;
    public plantilla $plantilla;

    public function mount()
    {
        $this->plantilla = plantilla::first();
    }

    public function yaExisteServicioCobro($productoActualId = null)
    {
        $query = Productos::where('empresa_id', session('empresa'))
            ->where('es_servicio_cobro', true);

        if ($productoActualId) {
            $query->where('id', '!=', $productoActualId);
        }

        return $query->exists();
    }

    public function render()
    {
        $yaExisteServicioCobro = $this->yaExisteServicioCobro($this->producto->id ?? null);
        return view('livewire.admin.items.edit-modal', compact('yaExisteServicioCobro'));
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
        if ($categoria_id != $this->producto->categoria_id) {
            $prefix    = 'PROD-' . $categoria_id;
            $prefixLen = strlen($prefix);

            $maxNumber = Productos::where('categoria_id', $categoria_id)
                ->withTrashed()
                ->selectRaw('MAX(CAST(SUBSTRING(codigo, ?) AS UNSIGNED)) as max_num', [$prefixLen + 1])
                ->value('max_num') ?? 0;

            $this->codigo = $prefix . str_pad($maxNumber + 1, 4, '0', STR_PAD_LEFT);
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
        $this->es_servicio_cobro = $producto->es_servicio_cobro;
        $this->es_dispositivo = $producto->es_dispositivo;
        $this->stock = $producto->stock;
        $this->valor_unitario = $producto->valor_unitario;
        $this->modelo_id = $producto->modelo_id;
        $this->precio_unitario = $this->valor_unitario * $this->plantilla->igvbase;

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

        $datos = $this->validate($request->rules($this->producto), $request->messages());


        try {
            $this->producto->update($datos);

            //save imagen
            if ($this->file) {

                $this->saveImage($this->producto);
            } else {

                $this->removeImage($this->producto);
            }

            $this->afterUpdate();
            $this->resetPropiedad();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function resetPropiedad()
    {
        $this->reset('descripcion', 'categoria_id', 'codigo', 'unit_code', 'stock', 'valor_unitario', 'ventas', 'divisa', 'tipo', 'afecto_icbper', 'es_servicio_cobro', 'es_dispositivo');
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
        $this->validateOnly($atributo, $request->rules($this->producto), $request->messages());
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
        $this->reset('file');
        $this->dispatch('update-table');
    }
    public function closeModal()
    {
        $this->modalEdit = false;
    }

    public function updatedPrecioUnitario($value)
    {
        $this->calcularValorUnitario();
    }

    public function calcularValorUnitario()
    {
        $this->valor_unitario = round($this->precio_unitario / $this->plantilla->igvbase, 4);
    }
}

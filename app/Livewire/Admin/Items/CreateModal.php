<?php

namespace App\Livewire\Admin\Items;

use Livewire\Component;
use App\Models\Productos;
use Livewire\Attributes\On;
use Intervention\Image\ImageManager;
use App\Http\Requests\ProductosRequest;
use App\Models\Categoria;
use App\Models\plantilla;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class CreateModal extends Component
{
    public $modalCreate = false;

    public $descripcion, $categoria_id, $codigo, $unit_code = "NIU",
        $stock = 1,  $valor_unitario = 0.00, $ventas = 0, $divisa = 'PEN',
        $tipo = '';

    public $precio_unitario = 0.00;
    public $afecto_icbper = false;
    public $es_servicio_cobro = false;
    public $es_dispositivo = false;
    public $file;

    public $modelo_id = null;
    public plantilla $plantilla;

    public function mount()
    {
        $this->plantilla = plantilla::first();
    }

    public function yaExisteServicioCobro()
    {
        return Productos::where('empresa_id', session('empresa'))
            ->where('es_servicio_cobro', true)
            ->exists();
    }

    public function render()
    {
        return view('livewire.admin.items.create-modal', [
            'yaExisteServicioCobro' => $this->yaExisteServicioCobro(),
        ]);
    }

    #[On(['open-modal-create', 'add-producto-modal'])]
    public function openModal($tipo = null)
    {
        $this->modalCreate = true;

        // Establecer el tipo según el contexto (productos o servicios)
        if ($tipo) {
            $this->tipo = $tipo;
        }
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
        $prefix    = 'PROD-' . $categoria_id;
        $prefixLen = strlen($prefix);

        $maxNumber = Productos::where('categoria_id', $categoria_id)
            ->withTrashed()
            ->selectRaw('MAX(CAST(SUBSTRING(codigo, ?) AS UNSIGNED)) as max_num', [$prefixLen + 1])
            ->value('max_num') ?? 0;

        $this->codigo = $prefix . str_pad($maxNumber + 1, 4, '0', STR_PAD_LEFT);
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
            $this->resetProps();
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
        $this->reset('descripcion', 'categoria_id', 'codigo', 'unit_code', 'stock', 'valor_unitario', 'ventas', 'divisa', 'tipo', 'afecto_icbper', 'es_servicio_cobro', 'es_dispositivo');
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

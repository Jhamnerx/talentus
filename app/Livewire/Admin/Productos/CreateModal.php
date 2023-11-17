<?php

namespace App\Livewire\Admin\Productos;

use Livewire\Component;
use App\Models\Productos;
use Livewire\Attributes\On;
use App\Http\Requests\ProductosRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class CreateModal extends Component
{
    public $modalCreate = false;

    public $descripcion, $categoria_id, $codigo, $unit_code = "NIU",
        $stock = 1,  $valor_unitario = 0.00, $ventas = 0, $divisa = 'PEN',
        $tipo = 'producto';
    public $afecto_icbper = false;
    public $file;

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
    }

    public function generateCodeProduct($categoria_id)
    {
        $producto =  Productos::where('categoria_id', $categoria_id)->latest()->first();

        $this->codigo = $producto ? 'PROD-' . $categoria_id . str_replace('PROD-', '', $producto["codigo"]) + 1 : $categoria_id . "000";
    }

    public function save()
    {
        //GUARDAR PRODUCTO
        $request = new ProductosRequest();

        $datos = $this->validate($request->rules());
        // dd($datos);
        $producto = Productos::create($datos);

        //save imagen
        if ($this->file) {
            $this->saveImage($producto);
        }

        $this->afterSave();
    }

    public function saveImage(Productos $producto): bool
    {

        $img = Image::make($this->file)->encode('jpg');
        $url = 'public/productos/' . $producto->codigo . '.png';
        Storage::disk('public')->put($url, $img, 'public');

        $producto->image()->create([
            'url' => $url
        ]);

        return true;
    }

    public function updated($atributo, $value)
    {

        $request = new ProductosRequest();
        $this->validateOnly($atributo, $request->rules());

        //  $this->redondeoPrecios($atributo, $value);
    }

    public function afterSave()
    {
        $this->dispatch(
            'notify',
            icon: 'success',
            tittle: 'PRODUCTO REGISTRADO',
            mensaje: 'se guardo correctamente el producto o servicio'
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
}

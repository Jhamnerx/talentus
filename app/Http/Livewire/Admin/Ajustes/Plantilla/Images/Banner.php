<?php

namespace App\Http\Livewire\Admin\Ajustes\Plantilla\Images;

use App\Models\Empresa;
use App\Models\plantilla;
use Livewire\Component;
use Livewire\WithFileUploads;

class Banner extends Component
{

    use WithFileUploads;
    public plantilla $plantilla;

    public $banner;

    public function render()
    {
        return view('livewire.admin.ajustes.plantilla.images.banner');
    }
    public function openModalDelete($titulo, $val)
    {

        $this->emit('openModal', $titulo, $val);
    }
    public function updatedImgDocumento()
    {

        $this->validate([
            'banner' => 'image|max:1024', // 1MB Max
        ], [
            'banner.image' => 'el archivo debe ser una imagen',
            'banner.max' => 'El tamaño debe ser menor a 1MB'
        ]);
    }
    public function saveImagenDocumentos()
    {
        $empresa = Empresa::actual()->first()->nombre;
        $this->validate([
            'banner' => 'image|max:1024', // 1MB Max
        ], [
            'banner.image' => 'el archivo debe ser una imagen',
            'banner.max' => 'El tamaño debe ser menor a 1MB'
        ]);

        $url = $this->banner->storeAs($empresa . '/imagenes', 'banner.png');
        $this->plantilla->banner = $url;
        $this->plantilla->save();
        $this->dispatchBrowserEvent('save.image', ['mensaje' => 'Imagen Banner Guardada Correctamente.']);
    }
}

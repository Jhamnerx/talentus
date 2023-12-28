<?php

namespace App\Livewire\Admin\Ajustes\Plantilla\Images;

use App\Models\Empresa;
use App\Models\plantilla;
use Livewire\Component;
use Livewire\WithFileUploads;

class Documentos extends Component
{

    use WithFileUploads;
    public plantilla $plantilla;

    public $img_documento;

    public function render()
    {
        return view('livewire.admin.ajustes.plantilla.images.documentos');
    }
    public function openModalDelete($titulo, $val)
    {

        $this->dispatch('openModal', $titulo, $val);
    }


    public function updatedImgDocumento()
    {

        $this->validate([
            'img_documento' => 'image|max:1024', // 1MB Max
        ], [
            'img_documento.image' => 'el archivo debe ser una imagen',
            'img_documento.max' => 'El tamaño debe ser menor a 1MB'
        ]);
    }

    public function saveImagenDocumentos()
    {
        $empresa = Empresa::actual()->first()->nombre;
        $this->validate([
            'img_documento' => 'image|max:1024', // 1MB Max
        ], [
            'img_documento.image' => 'el archivo debe ser una imagen',
            'img_documento.max' => 'El tamaño debe ser menor a 1MB'
        ]);
        $url = $this->img_documento->storeAs($empresa . '/imagenes', 'img_documento.png');
        $this->plantilla->img_documentos = $url;
        $this->plantilla->save();

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            tittle: 'IMAGEN GUARDADA',
            mensaje: 'Imagen Documentos Guardada Correctamente.'
        );
    }
}

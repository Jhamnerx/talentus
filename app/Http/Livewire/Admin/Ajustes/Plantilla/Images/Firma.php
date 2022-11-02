<?php

namespace App\Http\Livewire\Admin\Ajustes\Plantilla\Images;

use App\Models\Empresa;
use App\Models\plantilla;
use Livewire\Component;
use Livewire\WithFileUploads;

class Firma extends Component
{
    use WithFileUploads;
    public plantilla $plantilla;

    public $img_firma;

    public function render()
    {
        return view('livewire.admin.ajustes.plantilla.images.firma');
    }

    public function openModalDelete($titulo, $val)
    {

        $this->emit('openModal', $titulo, $val);
    }
    public function updatedImgFirma()
    {

        $this->validate([
            'img_firma' => 'image|max:1024', // 1MB Max
        ], [
            'img_firma.image' => 'el archivo debe ser una imagen',
            'img_firma.max' => 'El tamaño debe ser menor a 1MB'
        ]);
    }
    public function saveImagenDocumentos()
    {
        $empresa = Empresa::actual()->first()->nombre;
        $this->validate([
            'img_firma' => 'image|max:1024', // 1MB Max
        ], [
            'img_firma.image' => 'el archivo debe ser una imagen',
            'img_firma.max' => 'El tamaño debe ser menor a 1MB'
        ]);
        $url = $this->img_firma->storeAs($empresa . '/imagenes', 'img_firma.png');
        $this->plantilla->img_firma = $url;
        $this->plantilla->save();
        $this->dispatchBrowserEvent('save.image', ['mensaje' => 'Imagen img_firma Guardada Correctamente.']);
        //session()->flash('save.image', 'Imagen Documentos Guardada Correctamente.');
    }
}

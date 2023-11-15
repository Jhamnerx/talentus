<?php

namespace App\Livewire\Admin\Ajustes\Plantilla\Images;

use App\Models\Empresa;
use App\Models\plantilla;
use Livewire\Component;
use Livewire\WithFileUploads;

class Logo extends Component
{
    use WithFileUploads;
    public plantilla $plantilla;

    public $logo;

    public function render()
    {
        return view('livewire.admin.ajustes.plantilla.images.logo');
    }

    public function openModalDelete($titulo, $val)
    {

        $this->dispatch('openModal', $titulo, $val);
    }
    public function updatedLogo()
    {

        $this->validate([
            'logo' => 'image|max:1024', // 1MB Max
        ], [
            'logo.image' => 'el archivo debe ser una imagen',
            'logo.max' => 'El tamaño debe ser menor a 1MB'
        ]);
    }
    public function saveImagenDocumentos()
    {
        $empresa = Empresa::actual()->first()->nombre;
        $this->validate([
            'logo' => 'image|max:1024', // 1MB Max
        ], [
            'logo.image' => 'el archivo debe ser una imagen',
            'logo.max' => 'El tamaño debe ser menor a 1MB'
        ]);
        $url = $this->logo->storeAs($empresa . '/imagenes', 'logo.png');
        $this->plantilla->logo = $url;
        $this->plantilla->save();
        $this->dispatch('save.image', ['mensaje' => 'Imagen Logo Guardada Correctamente.']);
        //session()->flash('save.image', 'Imagen Documentos Guardada Correctamente.');
    }
}

<?php

namespace App\Livewire\Admin\Ajustes\Plantilla\Images;

use App\Models\Empresa;
use App\Models\plantilla;
use Livewire\Component;
use Livewire\WithFileUploads;

class FavIcon extends Component
{
    use WithFileUploads;
    public plantilla $plantilla;

    public $fav_icon;

    public function render()
    {
        return view('livewire.admin.ajustes.plantilla.images.fav-icon');
    }
    public function openModalDelete($titulo, $val)
    {

        $this->dispatch('openModal', $titulo, $val);
    }
    public function updatedFavIcon()
    {

        $this->validate([
            'fav_icon' => 'image|max:1024', // 1MB Max
        ], [
            'fav_icon.image' => 'el archivo debe ser una imagen',
            'fav_icon.max' => 'El tamaño debe ser menor a 1MB'
        ]);
    }
    public function saveImagenDocumentos()
    {
        $empresa = Empresa::actual()->first()->nombre;
        $this->validate([
            'fav_icon' => 'image|max:1024', // 1MB Max
        ], [
            'fav_icon.image' => 'el archivo debe ser una imagen',
            'fav_icon.max' => 'El tamaño debe ser menor a 1MB'
        ]);
        $url = $this->fav_icon->storeAs($empresa . '/imagenes', 'fav_icon.png');
        $this->plantilla->fav_icon = $url;
        $this->plantilla->save();

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            tittle: 'IMAGEN GUARDADA',
            mensaje: 'Imagen FavIcon Guardada Correctamente.'
        );
    }
}

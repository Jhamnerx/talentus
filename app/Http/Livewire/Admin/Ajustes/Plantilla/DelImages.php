<?php

namespace App\Http\Livewire\Admin\Ajustes\Plantilla;

use App\Models\plantilla;
use DASPRiD\EnumTest\Planet;
use Livewire\Component;

class DelImages extends Component
{
    public $titulo = '';
    public $modalDelete = false;

    public $val;


    protected $listeners = [
        'openModal',
    ];




    public function render()
    {
        return view('livewire.admin.ajustes.plantilla.del-images');
    }


    public function openModal($titulo, $val)
    {
        $this->val = $val;
        $this->titulo = $titulo;
        $this->modalDelete = true;
    }

    public function delete()
    {
        $plantilla = plantilla::first();
        $plantilla->update([
            $this->val => '',
        ]);

        return redirect()->route('admin.ajustes.plantilla')->with('delete', $this->titulo . ' Fue Eliminada');
    }
}

<?php

namespace App\Livewire\Admin\Inicio\Cards;

use App\Models\ModelosDispositivo;
use Livewire\Component;

class Dispositivos extends Component
{
    public function render()
    {

        $modelos = ModelosDispositivo::all();
        // dd($modelos);
        return view('livewire.admin.inicio.cards.dispositivos', compact('modelos'));
    }
}

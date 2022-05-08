<?php

namespace App\Http\Livewire\Admin\Lineas;

use App\Models\CambiosLineas;
use Livewire\Component;

class VerCambios extends Component
{
    public $sim_card;


    public function render()
    {

        $cambios = CambiosLineas::where('sim_card_id', $this->sim_card->id)->orderBy('id', 'desc')->get();

        //dd($cambios);
        return view('livewire.admin.lineas.ver-cambios', compact('cambios'));
    }
}

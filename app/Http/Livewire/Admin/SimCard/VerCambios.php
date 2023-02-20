<?php

namespace App\Http\Livewire\Admin\SimCard;

use App\Models\CambiosLineas;
use Livewire\Component;

class VerCambios extends Component
{
    public $sim_card;

    protected $listeners = ['render' => 'render'];

    public function render()
    {

        $cambios = CambiosLineas::where('sim_card_id', $this->sim_card->id)->orderBy('id', 'desc')->get();

        //dd($cambios);
        return view('livewire.admin.sim-card.ver-cambios', compact('cambios'));
    }
}

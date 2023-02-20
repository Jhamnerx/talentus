<?php

namespace App\Http\Livewire\Admin\SimCard;

use App\Models\Lineas;
use Livewire\Component;

class AsignLinea extends Component
{

    public $sim_card_id, $numero, $motivo, $value;

    public function render()
    {
        return view('livewire.admin.sim-card.asign-linea');
    }
}

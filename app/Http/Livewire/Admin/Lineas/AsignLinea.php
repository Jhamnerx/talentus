<?php

namespace App\Http\Livewire\Admin\Lineas;

use App\Models\Lineas;
use Livewire\Component;

class AsignLinea extends Component
{

    public $sim_card_id, $numero, $motivo, $value;



    public function render()
    {
        return view('livewire.admin.lineas.asign-linea');
    }
    public function store($sim_card_id)
    {
        $this->value = $sim_card_id;
        //return $this->sim_card;
        dd($this->value);
        //return $this->sim_card;
        //dd($this->sim_card);
    }
    public function save()
    {
    }
}

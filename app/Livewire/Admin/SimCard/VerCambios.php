<?php

namespace App\Livewire\Admin\SimCard;

use App\Models\CambiosLineas;
use App\Models\SimCard;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class VerCambios extends Component
{
    public $sim_card;

    protected $listeners = ['render' => 'render'];

    public $modalOpen = false;

    public $cambios;

    public function render()
    {

        //
        return view('livewire.admin.sim-card.ver-cambios');
    }

    #[On('open-modal-cambios')]
    public function showModal(SimCard $sim_card)
    {
        $this->modalOpen = true;
        $this->sim_card = $sim_card;
        $this->cambios = $sim_card->cambios;
    }
}

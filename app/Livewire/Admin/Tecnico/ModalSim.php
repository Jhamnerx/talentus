<?php

namespace App\Livewire\Admin\Tecnico;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Collection;

class ModalSim extends Component
{
    use WithPagination;

    public $openModal = false;
    //   public $sim_cards;
    public $user;

    // public function mount()
    // {

    //     $this->sim_cards = collect([]);
    // }

    public function render()
    {
        if ($this->user) {
            $sim_cards = $this->user->sim_cards()->paginate(5, pageName: 'sim-page');
        } else {

            $sim_cards = null;
        }
        return view('livewire.admin.tecnico.modal-sim', compact('sim_cards'));
    }

    #[On('open-modal-sim')]
    public function openModal(User $user)
    {

        $this->openModal = true;
        $this->user = $user;
        //$this->sim_cards = $user->sim_cards()->paginate(5, *, 'sim-page', 1);
    }
}

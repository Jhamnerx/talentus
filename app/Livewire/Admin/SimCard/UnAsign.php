<?php

namespace App\Livewire\Admin\SimCard;

use App\Models\CambiosLineas;
use App\Models\Lineas;
use App\Models\SimCard;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class UnAsign extends Component
{
    use WireUiActions;

    public SimCard $sim_card;
    public $openUnAsign = false;

    public function render()
    {
        return view('livewire.admin.sim-card.un-asign');
    }

    #[On('open-modal-unasign')]
    public function openModal(SimCard $sim)
    {
        $this->openUnAsign = true;
        $this->sim_card = $sim;
    }

    public function closeModal()
    {
        $this->openUnAsign = false;
        $this->reset();
    }

    public function unAsign()
    {

        if ($this->sim_card) {
            CambiosLineas::create([
                'tipo_cambio' => 'Se elimino el numero asignado',
                'sim_card_id' => $this->sim_card->id,
                'old_numero' => $this->sim_card->lineas_id,
                'new_numero' => null,
                'user_id' => Auth::user()->id,
            ]);

            $linea = Lineas::findOrFail($this->sim_card->lineas_id);

            if ($linea) {
                // Guardar en tabla old_sim_cards usando la relación
                $linea->old_sim_cards()->create([
                    'old_sim_card' => $this->sim_card->sim_card,
                ]);
            }


            $this->sim_card->update([
                "lineas_id" => null,
            ]);

            $this->afterAction();
        }
    }

    public function afterAction()
    {
        $this->notification()->error(
            'Número eliminado',
            'El SIM card físico se encuentra sin número asignado'
        );

        $this->closeModal();
        $this->dispatch('update-table');
    }
}

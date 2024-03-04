<?php

namespace App\Livewire\Admin\SimCard;

use App\Models\Lineas;
use App\Models\SimCard;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\CambiosLineas;

class UnAsign extends Component
{
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
                'user_id' => auth()->user()->id,
            ]);

            $linea = Lineas::findOrFail($this->sim_card->lineas_id);

            if ($linea) {
                $linea->old_sim_card = $this->sim_card->sim_card;
                $linea->save();
            }


            $this->sim_card->update([
                "lineas_id" => null,
            ]);

            $this->afterAction();
        }
    }

    public function afterAction()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'SE ELIMINO EL NUMERO',
            mensaje: 'El sim card fisico se encuentra sin numero'
        );

        $this->closeModal();
        $this->dispatch('update-table');
    }
}

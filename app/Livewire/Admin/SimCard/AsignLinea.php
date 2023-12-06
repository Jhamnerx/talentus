<?php

namespace App\Livewire\Admin\SimCard;

use App\Models\Lineas;
use App\Models\SimCard;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\CambiosLineas;
use Illuminate\Support\Facades\Auth;

class AsignLinea extends Component
{

    public $modalAsign = false;
    public $sim_card_id, $lineas_id, $motivo;

    public SimCard $sim_card;
    public Lineas $linea;

    public function render()
    {
        return view('livewire.admin.sim-card.asign-linea');
    }

    #[On('open-modal-asign')]
    public function openModal()
    {
        $this->modalAsign = true;
    }
    public function closeModal()
    {
        $this->modalAsign = false;
    }

    public function clearSimCardId()
    {
        $this->reset('sim_card');
    }
    public function clearLineaId()
    {
        $this->reset('linea');
    }

    public function updatedSimCardId($value)
    {

        $value ? $this->sim_card  = SimCard::findOr($value, fn () => null) : null;
    }

    public function updatedLineasId($value)
    {

        $value ? $this->linea  = Lineas::findOr($value, fn () => null) : null;
    }
    public function save()
    {


        $this->validate([
            'sim_card_id' => 'required|exists:sim_card,id',
            'lineas_id' => 'required',
        ]);


        //verificar si enviamos el id de la linea
        if ($this->lineas_id) {

            # Si la linea esta asignada hacer lo siguiente
            if ($this->linea->sim_card) {

                $this->setOldSimCard($this->linea, $this->linea->sim_card->sim_card);
                #Registra el cambio
                CambiosLineas::create([
                    'tipo_cambio' => 'Asignacion de numero',
                    'sim_card_id' => $this->sim_card_id,
                    'old_numero' => $this->sim_card->linea ? $this->sim_card->linea->id : null,
                    'new_numero' => $this->lineas_id,
                    'user_id' => auth()->user()->id,
                ]);

                #colocar nulo la linea en el sim card
                $this->linea->sim_card->lineas_id = null;
                $this->linea->sim_card->save();

                //asignamos la nueva linea al sim card
                $this->sim_card->lineas_id = $this->lineas_id;
                $this->sim_card->save();

                //NOTIFY
                $this->afterSave();
            } else {
                # si no esta asignada
                # Si la linea no esta asignada hacer lo siguiente
                #lo mismo pero no verificamos el antiguo sim card
                #Registra el cambio
                CambiosLineas::create([
                    'tipo_cambio' => 'Asinacion de numero',
                    'sim_card_id' => $this->sim_card_id,
                    'old_numero' => $this->sim_card->linea ? $this->sim_card->linea->id : NULL,
                    'new_numero' => $this->lineas_id,
                    'user_id' => auth()->user()->id,
                ]);

                //asignamos la nueva linea al sim card
                $this->sim_card->lineas_id = $this->lineas_id;
                $this->sim_card->save();

                #Colocar el old sim card a la linea
                $this->linea->old_sim_card = null;
                $this->linea->save();

                #NOTIFY
                $this->afterSave();
            }
        }
    }

    public function setOldSimCard(Lineas $linea, $sim_card_old)
    {
        $linea->old_sim_card = $sim_card_old;

        $linea->save();

        $old = $linea->old_sim_cards()->create([
            'old_sim_card' =>  $sim_card_old,
            'user_id' => Auth::user()->id,
        ]);
    }

    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            tittle: 'LINEA ASIGNADA A SIM CARD',
            mensaje: 'Se asigno la linea ' . $this->linea->numero . ' al sim card: ' . $this->sim_card->sim_card
        );
        $this->reset('sim_card', 'linea', 'sim_card_id', 'lineas_id');
        $this->closeModal();
        $this->dispatch('update-table');
    }
}

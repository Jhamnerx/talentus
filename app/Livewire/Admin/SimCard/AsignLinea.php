<?php

namespace App\Livewire\Admin\SimCard;

use App\Models\Lineas;
use App\Models\SimCard;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\CambiosLineas;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Auth;

class AsignLinea extends Component
{
    use WireUiActions;

    public $modalAsign = true;
    public $sim_card_id, $lineas_id, $motivo;

    public ?SimCard $sim_card = null;
    public ?Lineas $linea = null;

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
        $this->sim_card_id = null;
        $this->reset('sim_card');
    }
    public function clearLineaId()
    {
        $this->lineas_id = null;
        $this->reset('linea');
    }

    public function updatedSimCardId($value)
    {

        $value ? $this->sim_card  = SimCard::findOr($value, fn() => null) : null;
    }

    public function updatedLineasId($value)
    {

        $value ? $this->linea  = Lineas::findOr($value, fn() => null) : null;
    }
    public function save()
    {
        $this->validate([
            'sim_card_id' => 'required|exists:sim_card,id',
            'lineas_id' => 'required|exists:lineas,id',
        ]);

        // Verificar que el SIM card NO tenga línea asignada
        if ($this->sim_card->lineas_id) {
            $this->notification()->warning(
                title: 'SIM CARD YA TIENE LÍNEA',
                description: 'Este SIM card ya tiene el número ' . $this->sim_card->linea->numero . ' asignado. Usa "Cambiar número" en su lugar.'
            );
            return;
        }

        // Verificar que la línea NO tenga sim card asignado
        if ($this->linea->sim_card) {
            $this->notification()->warning(
                title: 'LÍNEA YA TIENE CHIP',
                description: 'Esta línea ya tiene el chip ' . $this->linea->sim_card->sim_card . ' asignado. Usa "Cambiar chip" en su lugar.'
            );
            return;
        }

        // Asignación simple: ambos están disponibles
        $this->sim_card->lineas_id = $this->lineas_id;
        $this->sim_card->save();

        // Registrar el cambio como nueva asignación
        CambiosLineas::create([
            'tipo_cambio' => 'Nueva asignación',
            'sim_card_id' => $this->sim_card_id,
            'old_numero' => null,
            'new_numero' => $this->lineas_id,
            'motivo' => $this->motivo,
            'user_id' => Auth::user()->id,
        ]);

        $this->afterSave();
    }

    public function afterSave()
    {
        $this->notification()->success(
            title: 'ASIGNACIÓN EXITOSA',
            description: 'Se asignó la línea ' . $this->linea->numero . ' al chip ' . $this->sim_card->sim_card
        );
        $this->reset('sim_card', 'linea', 'sim_card_id', 'lineas_id', 'motivo');
        $this->closeModal();
        $this->dispatch('update-table');
    }
}

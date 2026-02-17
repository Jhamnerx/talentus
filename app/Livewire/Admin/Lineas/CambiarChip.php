<?php

namespace App\Livewire\Admin\Lineas;

use App\Models\Lineas;
use App\Models\SimCard;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\CambiosLineas;
use App\Traits\GuardaHistorialSimCard;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Auth;

class CambiarChip extends Component
{
    use GuardaHistorialSimCard, WireUiActions;
    public $openModal = false;
    public Lineas $linea;
    public $nuevo_sim_card_id;
    public SimCard $nuevo_sim_card;
    public $motivo = '';

    protected $rules = [
        'nuevo_sim_card_id' => 'required|exists:sim_card,id',
        'motivo' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'nuevo_sim_card_id.required' => 'Debes seleccionar un SIM card',
        'nuevo_sim_card_id.exists' => 'El SIM card seleccionado no existe',
    ];

    public function render()
    {
        return view('livewire.admin.lineas.cambiar-chip');
    }

    #[On('open-modal-cambiar-chip')]
    public function openModal(Lineas $linea)
    {
        $this->openModal = true;
        $this->linea = $linea;
        $this->reset('nuevo_sim_card_id', 'motivo');
    }

    public function closeModal()
    {
        $this->openModal = false;
        $this->reset('nuevo_sim_card_id', 'motivo', 'nuevo_sim_card');
    }

    public function updatedNuevoSimCardId($value)
    {
        $this->nuevo_sim_card = $value ? SimCard::find($value) : null;
    }

    public function clearNuevoSimCard()
    {
        $this->reset('nuevo_sim_card', 'nuevo_sim_card_id');
    }

    public function cambiarChip()
    {
        $this->validate();

        // Verificar si el nuevo sim card ya tiene una línea
        if ($this->nuevo_sim_card->lineas_id) {
            $this->notification()->error(
                title: 'SIM Card ya tiene línea',
                description: 'El chip ' . $this->nuevo_sim_card->sim_card . ' ya tiene asignado el número: ' . $this->nuevo_sim_card->linea->numero
            );
            return;
        }

        // Guardar sim card anterior
        $sim_card_anterior = $this->linea->sim_card;
        $sim_card_anterior_numero = $sim_card_anterior ? $sim_card_anterior->sim_card : null;

        // Si había sim card anterior, guardar en historial
        if ($sim_card_anterior) {
            $this->guardarSimCardAnterior($this->linea, $sim_card_anterior->sim_card);

            // Liberar el sim card anterior
            $sim_card_anterior->update([
                'lineas_id' => null,
            ]);

            // Registrar cambio en el sim card anterior
            CambiosLineas::create([
                'tipo_cambio' => 'Cambio de chip - SIM anterior liberado',
                'sim_card_id' => $sim_card_anterior->id,
                'old_numero' => $this->linea->id,
                'new_numero' => null,
                'motivo' => $this->motivo,
                'user_id' => Auth::id(),
            ]);
        }

        // Asignar línea al nuevo sim card
        $this->nuevo_sim_card->update([
            'lineas_id' => $this->linea->id,
        ]);

        // Registrar cambio en el nuevo sim card
        CambiosLineas::create([
            'tipo_cambio' => 'Cambio de chip - Nueva asignación',
            'sim_card_id' => $this->nuevo_sim_card->id,
            'old_numero' => null,
            'new_numero' => $this->linea->id,
            'motivo' => $this->motivo,
            'user_id' => Auth::id(),
        ]);

        $this->notification()->success(
            title: '✅ Chip cambiado exitosamente',
            description: 'Línea ' . $this->linea->numero . ': ' .
                ($sim_card_anterior_numero ? 'SIM ' . $sim_card_anterior_numero . ' → ' : '') .
                'SIM ' . $this->nuevo_sim_card->sim_card
        );

        $this->closeModal();
        $this->dispatch('update-table');
    }
}

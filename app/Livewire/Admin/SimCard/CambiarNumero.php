<?php

namespace App\Livewire\Admin\SimCard;

use App\Models\Lineas;
use App\Models\SimCard;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\CambiosLineas;
use App\Traits\GuardaHistorialSimCard;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Auth;

class CambiarNumero extends Component
{
    use GuardaHistorialSimCard, WireUiActions;
    public $openModal = false;
    public SimCard $sim_card;
    public $nueva_linea_id;
    public Lineas $nueva_linea;
    public $motivo = '';

    protected $rules = [
        'nueva_linea_id' => 'required|exists:lineas,id',
        'motivo' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'nueva_linea_id.required' => 'Debes seleccionar una línea',
        'nueva_linea_id.exists' => 'La línea seleccionada no existe',
    ];

    public function render()
    {
        return view('livewire.admin.sim-card.cambiar-numero');
    }

    #[On('open-modal-cambiar-numero')]
    public function openModal(SimCard $sim_card)
    {
        $this->openModal = true;
        $this->sim_card = $sim_card;
        $this->reset('nueva_linea_id', 'motivo');
    }

    public function closeModal()
    {
        $this->openModal = false;
        $this->reset('nueva_linea_id', 'motivo', 'nueva_linea');
    }

    public function updatedNuevaLineaId($value)
    {
        $this->nueva_linea = $value ? Lineas::find($value) : null;
    }

    public function clearNuevaLinea()
    {
        $this->reset('nueva_linea', 'nueva_linea_id');
    }

    public function cambiarNumero()
    {
        $this->validate();

        // Verificar si la nueva línea ya está asignada a otro sim card
        if ($this->nueva_linea->sim_card) {
            $this->notification()->error(
                title: 'Línea ya asignada',
                description: 'La línea ' . $this->nueva_linea->numero . ' ya está asignada al sim card: ' . $this->nueva_linea->sim_card->sim_card
            );
            return;
        }

        // Guardar línea anterior
        $linea_anterior_id = $this->sim_card->lineas_id;
        $linea_anterior_numero = $this->sim_card->linea ? $this->sim_card->linea->numero : null;

        // Registrar cambio
        CambiosLineas::create([
            'tipo_cambio' => 'Cambio de número',
            'sim_card_id' => $this->sim_card->id,
            'old_numero' => $linea_anterior_id,
            'new_numero' => $this->nueva_linea_id,
            'motivo' => $this->motivo,
            'user_id' => Auth::id(),
        ]);

        // Si había línea anterior, guardar el sim card en el historial
        if ($linea_anterior_id) {
            $linea_anterior = Lineas::find($linea_anterior_id);
            if ($linea_anterior) {
                $this->guardarSimCardAnterior($linea_anterior, $this->sim_card->sim_card);
            }
        }

        // Asignar nueva línea al sim card
        $this->sim_card->update([
            'lineas_id' => $this->nueva_linea_id,
        ]);

        $this->notification()->success(
            title: '✅ Número cambiado exitosamente',
            description: 'SIM Card ' . $this->sim_card->sim_card . ': ' .
                ($linea_anterior_numero ? $linea_anterior_numero . ' → ' : '') .
                $this->nueva_linea->numero
        );

        $this->closeModal();
        $this->dispatch('update-table');
    }
}

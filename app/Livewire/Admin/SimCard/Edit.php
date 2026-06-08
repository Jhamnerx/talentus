<?php

namespace App\Livewire\Admin\SimCard;

use App\Models\SimCard;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{
    public $modalEdit = false;
    public SimCard $sim_card;

    public $imei, $operador_id;

    protected function rules()
    {
        return [
            'operador_id' => 'required|exists:operadores,id',
            "imei"  => "required|distinct|numeric|unique:sim_card,sim_card,{$this->sim_card->id}",

        ];
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function messages()
    {

        return [
            'sim_card.required' => 'El sim card es requerido',
            'sim_card.unique' => 'El sim card ya existe',
            'sim_card.distinct' => 'ya estas registrando este sim card',
            'sim_card.numeric' => 'El campo no debe contener letras',
            'operador_id.required' => 'El operador es requerido',
            'operador_id.exists' => 'Selecciona un operador válido',
        ];
    }

    public function render()
    {
        $operadores = \App\Models\Operador::orderBy('name')->get();
        return view('livewire.admin.sim-card.edit', compact('operadores'));
    }
    #[On('sim-card-open-modal-edit')]
    public function openModal(SimCard $sim_card)
    {
        $this->modalEdit = true;
        $this->sim_card = $sim_card;
        $this->imei = $sim_card->sim_card;
        $this->operador_id = $sim_card->operador_id;
    }

    public function save()
    {
        $this->validate();
        try {
            $this->sim_card->update([
                'sim_card'    => $this->imei,
                'operador_id' => $this->operador_id,
            ]);
            $this->afterSave();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: $th->getMessage(),
            );
        }
    }

    // sin updatedOperador ya que ahora es ID numérico

    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'SIM CARD ACTUALIZADA',
            mensaje: 'se actualizo correctamente la sim card'
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }

    public function closeModal()
    {
        $this->modalEdit = false;
        $this->resetprops();
    }

    public function resetProps()
    {
        $this->imei = '';
        $this->operador_id = null;
    }
}

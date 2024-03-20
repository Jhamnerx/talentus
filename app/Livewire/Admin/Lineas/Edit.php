<?php

namespace App\Livewire\Admin\Lineas;


use App\Models\Lineas;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{
    public $modalEdit = false;
    public Lineas $linea;

    public $numero, $operador;

    protected function rules()
    {
        return [
            'operador' => 'required|alpha:ascii',
            "numero"  => "required|distinct|numeric|unique:lineas,numero,{$this->linea->id}",

        ];
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function messages()
    {

        return [
            'numero.required' => 'El sim card es requerido',
            'numero.unique' => 'El sim card ya existe',
            'numero.distinct' => 'ya estas registrando este sim card',
            'numero.numeric' => 'El campo no debe contener letras',
            'operador.required' => 'El operador es requerido',
            'operador.alpha' => 'El campo no debe contener números',
        ];
    }


    public function render()
    {
        return view('livewire.admin.lineas.edit');
    }


    #[On('open-modal-edit')]
    public function openModal(Lineas $linea)
    {
        $this->modalEdit = true;
        $this->linea = $linea;
        $this->numero = $linea->numero;
        $this->operador = $linea->operador;
    }

    public function save()
    {
        $this->validate();
        try {
            $this->linea->update([
                'numero' => $this->numero,
                'operador' => $this->operador,
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

    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'LINEA ACTUALIZADA',
            mensaje: 'se actualizo correctamente las linea'
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
        $this->numero = '';
        $this->operador = '';
    }
}

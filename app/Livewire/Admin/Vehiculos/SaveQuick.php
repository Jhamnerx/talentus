<?php

namespace App\Livewire\Admin\Vehiculos;

use App\Models\Clientes;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use Livewire\Component;

class SaveQuick extends Component
{

    public $modalOpen = false;
    public $flotas;
    public $flotas_selected = [];
    public $placa, $marca, $modelo, $tipo, $year, $color, $motor, $serie, $clientes_id;


    protected function rules()
    {
        return [
            'placa' => 'required|unique:vehiculos',
            "marca" => 'nullable',
            "modelo" => 'nullable',
            "tipo" => 'nullable',
            "year" => 'nullable',
            "color" => 'nullable',
            "motor" => 'nullable',
            "serie" => 'nullable',
            "clientes_id"  => "required",
        ];
    }
    protected function messages()
    {
        return [
            'placa.required' => 'Ingresa una placa',
            'placa.unique' => 'La placa ingresada ya esta registrada',
            'clientes_id.required' => 'Por favor seleccione un cliente',
        ];
    }
    public function render()
    {
        return view('livewire.admin.vehiculos.save-quick');
    }

    #[On('open-modal-add-vehiculo')]
    public function openModal()
    {
        $this->modalOpen = true;
    }

    public function closeModal()
    {
        $this->modalOpen = false;
    }

    public function updatedClientesId($value)
    {

        $this->flotas = Clientes::find($value)->flotas()->get();
    }

    public function updated($attr)
    {
        $this->validateOnly($attr);
    }

    public function convertirAMayusculas()
    {
        $this->placa = strtoupper($this->placa);
    }

    public function save()
    {
        $this->validate();

        $vehiculo = Vehiculos::create([
            'placa' => $this->placa,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'tipo' => $this->tipo,
            'year' => $this->year,
            'color' => $this->color,
            'motor' => $this->motor,
            'serie' => $this->serie,
            'clientes_id' => $this->clientes_id,
        ]);


        if ($this->flotas_selected) {
            $vehiculo->flotas()->attach($this->flotas_selected);
        }

        $this->afterSave($vehiculo->placa);
    }

    public function afterSave($placa)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            tittle: 'VEHICULO REGISTRADO',
            mensaje: 'Se registro correctamente el vehiculo ' . $placa,
        );

        $this->closeModal();
        $this->dispatch('update-table');
        $this->reset();
    }
}

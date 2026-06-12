<?php

namespace App\Livewire\Admin\Dispositivos;

use App\Models\ModelosDispositivo;
use Illuminate\Support\Collection;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class AddModeloDispositivo extends Component
{
    use WireUiActions;

    public $modelo, $marca, $certificado, $tecnologia;
    public $modalOpen = false;
    public Collection $caracteristicas;

    protected  $rules = [
        'modelo' => 'required|unique:modelos_dispositivos',
        "marca" => 'nullable',
        "tecnologia" => 'nullable|string|max:50',
        "certificado" => 'nullable',
        "caracteristicas.*.text" => 'required',
    ];

    protected $messages = [
        'modelo.required' => 'El modelo es requerido',
        'modelo.unique' => 'Este Modelo ya esta registrado',
        'caracteristicas.*.text.required' => 'Ingresa una caracteristica',
    ];

    public function mount()
    {

        $this->caracteristicas = collect(
            []
        );
    }

    public function closeModal()
    {

        $this->modalOpen = false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset('modelo', 'marca', 'tecnologia', 'certificado');
    }

    public function save(): void
    {
        $validated = $this->validate();

        ModelosDispositivo::create($validated);

        $this->closeModal();
        $this->dispatch('ActualizarTabla');
        $this->notification()->success('MODELO REGISTRADO', 'El modelo GPS se guardó con éxito.');
    }
    public function render()
    {
        return view('livewire.admin.dispositivos.add-modelo-dispositivo');
    }
    public function updated($label)
    {

        $this->validateOnly($label);
    }

    public function updatedModelo($value)
    {
        $this->modelo = strtoupper($value);
    }
    public function updatedMarca($value)
    {
        $this->marca = strtoupper($value);
    }
    public function updatedTecnologia($value)
    {
        $this->tecnologia = strtoupper($value);
    }
    public function updatedCertificado($value)
    {
        $this->certificado = strtoupper($value);
    }
    public function addCaracteristica()
    {
        $this->caracteristicas->push([
            'text' => "",
        ]);
    }

    public function eliminarCaracteristica($key)
    {
        unset($this->caracteristicas[$key]);
    }
}

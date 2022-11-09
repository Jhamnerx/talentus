<?php

namespace App\Http\Livewire\Admin\Dispositivos;

use App\Models\ModelosDispositivo;
use Illuminate\Support\Collection;
use Livewire\Component;

class AddModeloDispositivo extends Component
{
    public $modelo, $marca, $certificado;
    public $modalOpen = false;
    public Collection $caracteristicas;

    protected  $rules = [
        'modelo' => 'required|unique:modelos_dispositivos',
        "marca" => 'nullable',
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
        $this->reset();
    }

    public function save()
    {
        $validatedDate = $this->validate();

        ModelosDispositivo::create($validatedDate);

        return redirect()->route('admin.almacen.modelos-dispositivos')->with('store-modelo', 'El modelo se guardo con exito');

        // CODIGO PARA GUARDAR LINEA
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

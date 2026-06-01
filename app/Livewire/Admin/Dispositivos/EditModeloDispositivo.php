<?php

namespace App\Livewire\Admin\Dispositivos;

use App\Http\Requests\ModelosDispositivosRequest;
use App\Models\ModelosDispositivo;
use Livewire\Component;

class EditModeloDispositivo extends Component
{
    public $modalEditOpen = false;

    public $modelo, $marca, $certificado, $tecnologia;
    public $caracteristicas;

    public $model;


    protected $listeners = ['abrirModal' => 'abrirModal'];

    public function mount()
    {

        $this->caracteristicas = collect(
            []
        );
    }

    public function render()
    {
        return view('livewire.admin.dispositivos.edit-modelo-dispositivo');
    }

    public function ActualizarModelo()
    {
        $requestModelo = new ModelosDispositivosRequest();

        $this->validate($requestModelo->rules($this->model), $requestModelo->messages());

        $this->model->update([
            'modelo' => $this->modelo,
            'marca' => $this->marca,
            'tecnologia' => $this->tecnologia,
            'certificado' => $this->certificado,
            'caracteristicas' => $this->caracteristicas,
        ]);

        $this->modalEditOpen = false;

        $this->dispatch('ActualizarTabla');
        $this->dispatch('update-modelo');
    }

    public function abrirModal(ModelosDispositivo $model)
    {
        $this->model = $model;
        $this->modelo = $model->modelo;
        $this->marca = $model->marca;
        $this->tecnologia = $model->tecnologia;
        $this->certificado = $model->certificado;
        $this->caracteristicas = collect($model->caracteristicas);
        $this->modalEditOpen = true;
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

    public function updated($label)
    {
        $requestModelo = new ModelosDispositivosRequest();
        $this->validateOnly($label, $requestModelo->rules($this->model), $requestModelo->messages());
    }

    public function updatedTecnologia($value)
    {
        $this->tecnologia = strtoupper($value);
    }
}

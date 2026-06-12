<?php

namespace App\Livewire\Admin\Dispositivos;

use App\Http\Requests\ModelosDispositivosRequest;
use App\Models\ModelosDispositivo;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class EditModeloDispositivo extends Component
{
    use WireUiActions;

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

    public function ActualizarModelo(): void
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
        $this->resetErrorBag();

        $this->dispatch('ActualizarTabla');
        $this->dispatch('update-modelo');
        $this->notification()->success('MODELO ACTUALIZADO', 'Los datos del modelo GPS se actualizaron.');
    }

    public function closeModal(): void
    {
        $this->modalEditOpen = false;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function abrirModal(ModelosDispositivo $model): void
    {
        $this->resetErrorBag();
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

<?php

namespace App\Http\Livewire\Admin\Dispositivos;

use App\Http\Requests\ModelosDispositivosRequest;
use App\Models\ModelosDispositivo;
use Livewire\Component;

class EditModeloDispositivo extends Component
{
    public $modalEditOpen = false;

    public $modelo, $marca, $certificado;

    public $model;


    protected $listeners = ['abrirModal' => 'abrirModal'];



    public function render()
    {
        return view('livewire.admin.dispositivos.edit-modelo-dispositivo');
    }


    // public function openModal()
    // {

    //     $this->modalEditOpen = true;
    // }
    public function ActualizarModelo()
    {
        $requestModelo = new ModelosDispositivosRequest();

        $this->validate($requestModelo->rules($this->model), $requestModelo->messages());

        $this->model->update([
            'modelo' => $this->modelo,
            'marca' => $this->marca,
            'certificado' => $this->certificado,
        ]);

        $this->modalEditOpen = false;

        $this->emit('ActualizarTabla');
    }
    public function abrirModal(ModelosDispositivo $model)
    {

        $this->model = $model;
        $this->modelo = $model->modelo;
        $this->marca = $model->marca;
        $this->certificado = $model->certificado;
        $this->modalEditOpen = true;
    }

    public function updated($label)
    {
        $requestModelo = new ModelosDispositivosRequest();
        $this->validateOnly($label, $requestModelo->rules($this->model), $requestModelo->messages());
        //dd($label);
    }
}

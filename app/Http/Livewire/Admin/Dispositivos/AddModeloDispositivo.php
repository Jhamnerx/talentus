<?php

namespace App\Http\Livewire\Admin\Dispositivos;

use App\Models\ModelosDispositivo;
use Livewire\Component;

class AddModeloDispositivo extends Component
{
    public $modelo, $marca, $certificado;
    public $modalOpen = false;
    protected  $rules = [
        'modelo' => 'required|unique:modelos_dispositivos',
        "marca" => 'nullable',
        "certificado" => 'nullable',

        // "dispositivos_id" => "required|unique:vehiculos",

    ];

    protected $messages = [
        'modelo.required' => 'El modelo es requerido',
        'modelo.unique' => 'Este Modelo ya esta registrado',


    ];

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
        //dd($label);
    }
}

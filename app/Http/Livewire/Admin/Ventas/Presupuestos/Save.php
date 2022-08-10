<?php

namespace App\Http\Livewire\Admin\Ventas\Presupuestos;

use Livewire\Component;

class Save extends Component
{

    public $numero;
    public $serial;

    protected $rules = [
        'numero' => 'required|unique:presupuestos,numero',
    ];

    protected $messages = [
        'numero.required' => 'El número requerido',
        'numero.unique' => 'El número ya esta registrado',

    ];

    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.save');
    }

    public function mount(){
        $this->numero = $this->serial;
    }

    public function updated($label)
    {

        $error = $this->validateOnly($label);
        
   
    }
}
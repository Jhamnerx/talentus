<?php

namespace App\Http\Livewire\Admin\Ventas\Recibos;

use Livewire\Component;

class ImputNumero extends Component
{
    public $numero;
    public $serie;

    protected $rules = [
        'numero' => 'required|unique:recibos,numero',
    ];

    protected $messages = [
        'numero.required' => 'El número requerido',
        'numero.unique' => 'El número ya esta registrado',

    ];
    public function render()
    {
        return view('livewire.admin.ventas.recibos.imput-numero');
    }
    public function mount(){
        $this->numero = $this->numero;
        $this->serie = $this->serie;
    }

    public function updated($label)
    {
        $error = $this->validateOnly($label);
        
    }
}

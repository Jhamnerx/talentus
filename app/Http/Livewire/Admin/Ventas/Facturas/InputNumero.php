<?php

namespace App\Http\Livewire\Admin\Ventas\Facturas;

use Illuminate\Validation\Rule;
use Livewire\Component;

class InputNumero extends Component
{
    public $numero;

    protected $messages = [
        'numero.required' => 'El número requerido',
        'numero.unique' => 'El número ya esta registrado',

    ];

    protected function rules()
    {
        return [

            'numero' => Rule::unique('facturas', 'numero')->where(fn ($query) => $query->where('empresa_id', session('empresa'))),

        ];
    }    




    public function render()
    {
        return view('livewire.admin.ventas.facturas.input-numero');
    }
    public function mount(){
        $this->numero = $this->numero;

    }

    public function updated($label)
    {

        $error = $this->validateOnly($label);
        
   
    }
}

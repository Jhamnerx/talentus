<?php

namespace App\Http\Livewire\Admin\Ventas\Presupuestos;

use Illuminate\Validation\Rule;
use Livewire\Component;

class Save extends Component
{

    public $numero;



    protected $messages = [
        'numero.required' => 'El número requerido',
        'numero.unique' => 'El número ya esta registrado',

    ];

    protected function rules()
    {
        return [

            //'numero' => Rule::unique('presupuestos', 'numero')->ignore(session('empresa'), 'empresa_id'),
            'numero' => Rule::unique('presupuestos', 'numero')->where(fn ($query) => $query->where('empresa_id', session('empresa'))),

        ];
    }    

    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.save');
    }

    public function mount(){

        $this->numero = $this->numero;
    }

    public function updated($label)
    {

        $error = $this->validateOnly($label);
        
   
    }
}

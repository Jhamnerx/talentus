<?php

namespace App\Http\Livewire\Admin\Lineas;

use App\Models\Lineas;
use Livewire\Component;

class Save extends Component
{


    public $numero, $operador;
    public $empresa_id;
    public $inputs = [];
    public $i = 0;


    protected $rules = [
        'operador.0' => 'required',
        "numero.0"  => "required|distinct|unique:lineas,numero",

        'operador.*' => 'required',
        "numero.*"  => "required|distinct|unique:lineas,numero",

    ];

    protected $messages = [
        'numero.0.required' => 'El Número requerido',
        'numero.0.unique' => 'El Número ya existe',
        'numero.0.distinct' => 'ya estas registrando este sim',
        'operador.0.required' => 'El operador es requerido',

        'numero.*.required' => 'El Número es requerido',
        'numero.*.unique' => 'El Número ya existe',
        'numero.*.distinct' => 'ya estas registrando este numero',
        'operador.*.required' => 'El operador es requerido',
    ];

    public function mount()
    {
        $this->empresa_id = session('empresa');
    }

    public function render()
    {
        return view('livewire.admin.lineas.save');
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }
    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    private function resetInputFields()
    {
        $this->numero = '';
        $this->operador = '';
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function store()
    {
        $validatedDate = $this->validate();

        foreach ($this->operador as $key => $value) {

            Lineas::create([
                'numero' => $this->numero[$key],
                'operador' => $this->operador[$key],
                'empresa_id' => $this->empresa_id,
            ]);
        }

        $this->inputs = [];

        $this->resetInputFields();

        return redirect()->route('admin.almacen.lineas.index')->with('store', 'Se guardo con exito');
    }
}

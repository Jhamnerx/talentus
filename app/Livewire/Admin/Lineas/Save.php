<?php

namespace App\Livewire\Admin\Lineas;

use App\Models\Lineas;
use Livewire\Component;
use Illuminate\Support\Collection;

class Save extends Component
{

    public Collection $items;

    protected $rules = [

        'items.*.operador' => 'required|alpha:ascii',
        "items.*.numero"  => "required|distinct|unique:lineas,numero|numeric",

    ];

    protected $messages = [
        'items.*.numero.required' => 'El sim card es requerido',
        'items.*.numero.unique' => 'El sim card ya existe',
        'items.*.numero.distinct' => 'ya estas registrando este sim card',
        'items.*.numero.numeric' => 'El campo no debe contener letras',
        'items.*.operador.required' => 'El operador es requerido',
        'items.*.operador.alpha' => 'El campo no debe contener números',
    ];


    public function mount()
    {
        $this->items = collect();
        $this->items->push([
            'numero' => '',
            'operador' => '',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.lineas.save');
    }

    public function addItem()
    {
        $this->items->push([
            'numero' => '',
            'operador' => '',
        ]);
    }

    public function eliminarItem($key)
    {
        if (count($this->items) > 1) {
            unset($this->items[$key]);
        }
    }



    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function store()
    {
        $validatedDate = $this->validate();

        foreach ($this->items as $item) {

            $numero = Lineas::create($item);
        }

        return redirect()->route('admin.almacen.lineas.index')->with('store', 'Se guardo con exito');
    }
}

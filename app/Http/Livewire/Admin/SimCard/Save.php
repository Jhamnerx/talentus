<?php

namespace App\Http\Livewire\Admin\SimCard;


use App\Models\SimCard;
use Illuminate\Support\Collection;
use Livewire\Component;

class Save extends Component
{
    public Collection $items;

    protected $rules = [

        'items.*.operador' => 'required|alpha:ascii',
        "items.*.sim_card"  => "required|distinct|unique:sim_card,sim_card|numeric",

    ];

    protected $messages = [
        'items.*.sim_card.required' => 'El sim card es requerido',
        'items.*.sim_card.unique' => 'El sim card ya existe',
        'items.*.sim_card.distinct' => 'ya estas registrando este sim card',
        'items.*.sim_card.numeric' => 'El campo no debe contener letras',
        'items.*.operador.required' => 'El operador es requerido',
        'items.*.operador.alpha' => 'El campo no debe contener números',
    ];




    public function mount()
    {
        $this->items = collect();
        $this->items->push([
            'sim_card' => '',
            'operador' => '',
        ]);
    }

    public function addItem()
    {
        $this->items->push([
            'sim_card' => '',
            'operador' => '',
        ]);
    }


    public function eliminarItem($key)
    {
        if (count($this->items) > 1) {
            unset($this->items[$key]);
        }
    }

    public function store()
    {
        $validatedDate = $this->validate();

        foreach ($this->items as $item) {

            $sim_card = SimCard::create($item);
        }

        return redirect()->route('admin.almacen.sim-card.index')->with('store', 'Se guardo con exito');
    }

    public function render()
    {
        return view('livewire.admin.sim-card.save');
    }

    public function updated($attr)
    {
        $this->validateOnly($attr);
    }
}

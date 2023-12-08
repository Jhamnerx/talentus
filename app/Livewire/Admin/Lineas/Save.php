<?php

namespace App\Livewire\Admin\Lineas;

use App\Models\Lineas;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

class Save extends Component
{

    public Collection $items;
    public $modalCreate = false;

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


    public function cancel()
    {
        $this->inicializarItems();
    }


    public function mount()
    {

        $this->inicializarItems();
    }

    public function inicializarItems()
    {
        $this->items = collect();
        $this->items->push([
            'numero' => '',
            'operador' => '',
        ]);
    }

    #[On('open-modal-create')]
    public function openModal()
    {
        $this->modalCreate = true;
    }
    public function closeModal()
    {
        $this->modalCreate = false;
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


    public function save()
    {
        $validatedDate = $this->validate();

        foreach ($this->items as $item) {

            $numero = Lineas::create($item);
        }

        $this->afterSave();
    }
    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            tittle: 'LINEAS REGISTRADAS',
            mensaje: 'se guardo correctamente las lineas'
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
}

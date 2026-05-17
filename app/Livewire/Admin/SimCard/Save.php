<?php

namespace App\Livewire\Admin\SimCard;


use App\Models\SimCard;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Save extends Component
{
    public Collection $items;
    public $modalCreate = false;

    protected $rules = [

        'items.*.operador_id' => 'required|exists:operadores,id',
        "items.*.sim_card"  => "required|distinct|unique:sim_card,sim_card|numeric",

    ];

    protected $messages = [
        'items.*.sim_card.required' => 'El sim card es requerido',
        'items.*.sim_card.unique' => 'El sim card ya existe',
        'items.*.sim_card.distinct' => 'ya estas registrando este sim card',
        'items.*.sim_card.numeric' => 'El campo no debe contener letras',
        'items.*.operador.required' => 'El operador es requerido',
        'items.*.operador.exists' => 'Selecciona un operador válido',
    ];

    #[On(['sim-card-open-modal-create', 'add-sim-card-modal'])]
    public function openModal()
    {
        $this->modalCreate = true;
    }

    public function closeModal()
    {
        $this->modalCreate = false;
        $this->cancel();
    }
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
            'sim_card' => '',
            'operador_id' => '',
        ]);
    }

    public function addItem()
    {
        $this->items->push([
            'sim_card' => '',
            'operador_id' => '',
        ]);
    }


    public function eliminarItem($key)
    {
        if (count($this->items) > 1) {
            unset($this->items[$key]);
        }
    }

    public function save()
    {
        $data = $this->validate();

        try {

            foreach ($data['items'] as $item) {

                SimCard::create($item);
            }

            $this->afterSave();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function updatedItems($value)
    {
        // sin transformación de texto ya que ahora es ID
    }

    public function render()
    {
        $operadores = \App\Models\Operador::orderBy('name')->get();
        return view('livewire.admin.sim-card.save', compact('operadores'));
    }

    public function updated($attr)
    {
        $this->validateOnly($attr);
    }

    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'SIM CARDS REGISTRADO',
            mensaje: 'se guardo correctamente los sim cards'
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
}

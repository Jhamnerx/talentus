<?php

namespace App\Livewire\Admin\Dispositivos;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;
use App\Http\Requests\DispositivosRequest;
use App\Models\Dispositivos;

class Save extends Component
{
    public $modalCreate = false;
    public Collection $items;

    public function render()
    {
        return view('livewire.admin.dispositivos.save');
    }


    public function updated($attr)
    {

        $request = new DispositivosRequest();
        $this->validateOnly($attr, $request->rules(), $request->messages());
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
            'imei' => '',
            'modelo_id' => '',
            'of_client' => '',
        ]);
    }

    public function addItem()
    {
        $this->items->push([
            'imei' => '',
            'modelo_id' => '',
            'of_client' => '',
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
        $request = new DispositivosRequest();
        $this->validate($request->rules(), $request->messages());

        foreach ($this->items as $item) {

            Dispositivos::create($item);
        }

        $this->afterSave();
    }

    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            tittle: 'DISPOSITIVOS REGISTRADOS',
            mensaje: 'se ha registrado correctamente los imei'
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
}

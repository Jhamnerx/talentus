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
            'of_client' => false,
        ]);
    }

    public function addItem()
    {
        $this->items->push([
            'imei' => '',
            'modelo_id' => '',
            'of_client' => false,
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
        $data = $this->validate($request->rules(), $request->messages());

        try {
            $this->saveItems($data['items']);
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

    public function saveItems($items)
    {
        foreach ($items as $item) {
            Dispositivos::create($item);
        }
    }


    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'DISPOSITIVOS REGISTRADOS',
            mensaje: 'se ha registrado correctamente los imei'
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }

    #[On('add-imei-modal')]
    public function registrarImei($imei)
    {
        $this->items = collect(
            [

                [
                    'imei' => $imei,
                    'modelo_id' => '',
                    'of_client' => false,
                ]
            ]
        );


        $this->openModal();
    }
}

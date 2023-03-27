<?php

namespace App\Http\Livewire\Admin\Dispositivos;

use App\Models\Dispositivos;
use Livewire\Component;
use App\Models\ModelosDispositivo;

class SaveQuick extends Component
{

    public $modalOpen = false;
    public $imei, $modelo_id, $of_client = 0;

    protected function rules()
    {

        return [
            'imei' => 'required|unique:dispositivos',
            'modelo_id' => 'required|exists:modelos_dispositivos,id'
        ];
    }

    protected function messages()
    {

        return [
            'imei.required' => 'Ingresa un imei',
            'imei.unique' => 'Este imei ya existe',
            'modelo_id.required' => 'Selecciona un modelo',
            'modelo_id.exists' => 'Selecciona un modelo',

        ];
    }

    public function render()
    {
        $modelos = ModelosDispositivo::pluck('modelo', 'id');

        return view('livewire.admin.dispositivos.save-quick', compact('modelos'));
    }

    public function save()
    {
        $this->validate();

        $dispositivo = Dispositivos::create([
            'imei' => $this->imei,
            'modelo_id' => $this->modelo_id,
            'of_client' => $this->of_client,
        ]);

        $this->closeModal();

        $this->reset();
        $this->dispatchBrowserEvent('save-quick-imei', ['imei' => $dispositivo->imei]);
    }

    public function openModal()
    {
        $this->modalOpen = true;
        $this->reset('of_client');
    }

    public function closeModal()
    {
        $this->modalOpen = false;
    }
    public function updated($attr)
    {

        $this->validateOnly($attr);
    }
}

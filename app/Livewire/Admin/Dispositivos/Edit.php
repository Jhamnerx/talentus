<?php

namespace App\Livewire\Admin\Dispositivos;

use App\Models\Dispositivos;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public $imei, $modelo_id, $of_client = false;

    public $modalEdit = false;
    public Dispositivos $dispositivo;
    public function render()
    {
        return view('livewire.admin.dispositivos.edit');
    }

    #[On('open-modal-edit')]
    public function openModal(Dispositivos $dispositivo)
    {

        $this->modalEdit = true;
        $this->dispositivo = $dispositivo;
        $this->imei = $dispositivo->imei;
        $this->modelo_id = $dispositivo->modelo_id;
        $this->of_client = $dispositivo->of_client  ? true : false;
    }

    public function closeModal()
    {
        $this->modalEdit = false;
    }
    public function cancel()
    {
        $this->reset('imei', 'modelo_id', 'of_client');
        $this->closeModal();
    }

    public function save()
    {
        $this->dispositivo->update([
            'imei' => $this->imei,
            'modelo_id' => $this->modelo_id,
            'of_client' => $this->of_client,
        ]);
        $this->afterSave();
    }

    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'DISPOSITIVO ACTUALIZADO',
            mensaje: 'se ha actualizado correctamente el dispositivo'
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
}

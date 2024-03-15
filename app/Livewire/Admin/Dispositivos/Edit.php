<?php

namespace App\Livewire\Admin\Dispositivos;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Dispositivos;
use App\Http\Requests\DispositivosRequest;

class Edit extends Component
{
    public $imei, $modelo_id, $of_client = false;

    public $modalEdit = false;
    public Dispositivos $dispositivo;
    public function render()
    {
        return view('livewire.admin.dispositivos.edit');
    }

    protected function rules()
    {
        return [
            'imei' => 'required|unique:dispositivos,imei,' . $this->dispositivo->id,
            'modelo_id' => 'required'
        ];
    }

    protected function messages()
    {
        return [
            'imei.required' => 'El imei es requerido',
            'imei.unique' => 'El imei ingresaso ya existe',
            'imei.distinct' => 'ya estas registrando este imei',
            'imei.numeric' => 'El campo no debe contener letras',
            'modelo_id.required' => 'El modelo es requerido',

        ];
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

        $data = $this->validate();
        try {
            $this->dispositivo->update($data);
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

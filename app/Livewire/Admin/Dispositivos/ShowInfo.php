<?php

namespace App\Livewire\Admin\Dispositivos;

use App\Http\Controllers\Admin\FotaWebApiController;
use App\Models\Dispositivos;
use Livewire\Attributes\On;
use Livewire\Component;


class ShowInfo extends Component
{
    public $modalOpen = false;
    public $datos = [];

    public function mount()
    {
        $this->datos =
            collect([
                'status' => "error",
                'imei' => '',
                'model' => '',
                'current_configuration' => '',
                'current_firmware' => '',
                'description' => '',
                'company_name' => '',
                'group_name' => '',
                'seen_at' => '',
            ]);
    }

    public function render()
    {
        return view('livewire.admin.dispositivos.show-info');
    }
    #[On('show-info-dispositivo')]
    public function openModalInfo(Dispositivos $dispositivo)
    {
        $this->openModal();

        $api = new FotaWebApiController();
        $info = $api->getDevice($dispositivo->imei);

        if ($info) {
            $this->datos = collect([
                'status' => "ok",
                'imei' => $info->imei,
                'model' => $info->model,
                'current_configuration' => $info->current_configuration,
                'current_firmware' => $info->current_firmware,
                'description' => $info->description,
                'company_name' => $info->company_name,
                'group_name' => $info->group_name,
                'iccid' => $info->iccid,
                'imsi' => $info->imsi,
                'seen_at' => $info->seen_at,
            ]);
        } else {

            $this->resetDatos();
        }
    }

    public function openModal()
    {
        $this->modalOpen = true;
    }
    public function closeModal()
    {
        $this->modalOpen = false;
        $this->resetDatos();
    }

    public function resetDatos()
    {
        $this->datos =
            collect([
                'status' => "error",
                'imei' => '',
                'model' => '',
                'current_configuration' => '',
                'current_firmware' => '',
                'description' => '',
                'company_name' => '',
                'group_name' => '',
                'seen_at' => '',
            ]);
    }
}

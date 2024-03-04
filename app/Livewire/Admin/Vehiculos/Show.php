<?php

namespace App\Livewire\Admin\Vehiculos;

use Livewire\Component;
use App\Models\Vehiculos;
use App\Http\Controllers\Admin\FotaWebApiController;

class Show extends Component
{
    public Vehiculos $vehiculo;
    public $dispositivo = [];
    public function mount()
    {

        $api = new FotaWebApiController();

        if ($this->vehiculo->dispositivos) {


            $info = $api->getDevice($this->vehiculo->dispositivos->imei);

            if ($info) {
                $this->dispositivo = collect([
                    'status' => "ok",
                    'imei' => $info->imei,
                    'model' => $info->model,
                    'current_configuration' => $info->current_configuration,
                    'current_firmware' => $info->current_firmware,
                    'description' => $info->description,
                    'company_name' => $info->company_name,
                    'group_name' => $info->group_name,
                    'seen_at' => $info->seen_at,
                ]);
            } else {

                $this->resetDatos();
            }
        } else {
            $this->resetDatos();
        }
    }

    public function resetDatos()
    {
        $this->dispositivo =
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
        return view('livewire.admin.vehiculos.show');
    }
}

<?php

namespace App\Livewire\Admin\Vehiculos;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\GpsWox\Api\GpsWoxApiController;
use App\Models\Vehiculos;

class GetInfoDeviceWox extends Component
{
    public $openModal = false;
    public $devices = [];

    public function render()
    {
        return view('livewire.admin.vehiculos.get-info-device-wox');
    }

    #[On('open-modal-info-wox')]
    public function openModal(Vehiculos $vehiculo)
    {
        $this->openModal = true;
        $this->getDevices($vehiculo->placa);
    }

    public function getDevices($placa)
    {

        $woxApi = new GpsWoxApiController();

        $response = $woxApi->getDevices(new \Illuminate\Http\Request([
            'perPage' => 1,
            's' => $placa,
        ]));

        $this->devices = $this->extractItemsFromGroups($response);
        dd($this->devices);
    }

    private function extractItemsFromGroups(array $groups): array
    {
        $allItems = [];

        // Recorre todos los grupos y extrae sus items
        foreach ($groups as $group) {
            if (isset($group['items']) && is_array($group['items'])) {
                $allItems = array_merge($allItems, $group['items']);
            }
        }

        return $allItems;
    }
}

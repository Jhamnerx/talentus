<?php

namespace App\Livewire\Admin\Vehiculos;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\GpsWox\Api\GpsWoxApiController;

class GetDevicesWox extends Component
{
    public $devices = [];
    public $openModal = false;

    public $page = 1;
    public $perPage = 10;
    public $search = '';

    public function render()
    {
        return view('livewire.admin.vehiculos.get-devices-wox');
    }


    public function getDevices()
    {
        $woxApi = new GpsWoxApiController();

        $response = $woxApi->getDevices(new \Illuminate\Http\Request([
            'page' => $this->page,
            'perPage' => $this->perPage,
            's' => $this->search,
        ]));

        $this->devices = $this->extractItemsFromGroups($response);
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


    #[On('get-devices-wox')]
    public function openModal()
    {
        $this->openModal = true;

        $this->getDevices();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
        $this->getDevices();
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->getDevices();
    }

    public function resetPage()
    {
        $this->page = 1;
    }

    public function previousPage()
    {
        // Disminuir página solo si no estamos en la primera
        if ($this->page > 1) {
            $this->page -= 1;
            $this->getDevices();
        }
    }

    public function nextPage()
    {
        // Aumentar página en 2
        $this->page += 1;
        $this->getDevices();
    }
}

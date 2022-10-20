<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use App\Models\Vehiculos;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{
    public Vehiculos $vehiculo;

    public $modalDelete = false;

    protected $listeners = [
        'deleteVehiculo' => 'openModal',
    ];

    public function delete()
    {
        $this->vehiculo->delete();
        // return redirect()->route('admin.vehiculos.index');
        $this->dispatchBrowserEvent('vehiculo-delete', ['delete' => $this->vehiculo]);

        $this->emit('updateTable');
    }


    public function openModal(Vehiculos $vehiculo)
    {
        $this->modalDelete = true;
        $this->vehiculo = $vehiculo;
    }


    public function render()
    {
        return view('livewire.admin.vehiculos.delete');
    }
}

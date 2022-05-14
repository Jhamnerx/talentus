<?php

namespace App\Http\Livewire\Admin\Vehiculos\Reportes;

use App\Models\Contactos;
use App\Models\Flotas;
use Livewire\Component;

class ShowContactos extends Component
{
    public $openModalContactos = false;

    public $flota_id = [];

    protected $listeners = [
        'showContactos' => 'openModal'
    ];

    public function render()
    {
        $contactos = Contactos::where('flotas_id', $this->flota_id)->orderBy('id', 'desc')->get();

        return view('livewire.admin.vehiculos.reportes.show-contactos', compact('contactos'));
    }

    public function openModal(Flotas $flota)
    {
        $this->openModalContactos = true;
        $this->flota_id = $flota->id;
        //dd($flota->contactos);
    }
}

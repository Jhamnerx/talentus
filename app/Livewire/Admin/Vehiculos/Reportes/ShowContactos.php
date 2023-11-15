<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Models\Clientes;
use App\Models\Contactos;
use App\Models\Flotas;
use Livewire\Component;

class ShowContactos extends Component
{
    public $openModalContactos = false;

    public $cliente_id = [];

    protected $listeners = [
        'showContactos' => 'openModal'
    ];

    public function render()
    {
        $contactos = Contactos::where('clientes_id', $this->cliente_id)->orderBy('id', 'desc')->get();

        return view('livewire.admin.vehiculos.reportes.show-contactos', compact('contactos'));
    }

    public function openModal(Clientes $cliente)
    {
        $this->openModalContactos = true;
        $this->cliente_id = $cliente->id;
        //dd($flota->contactos);
    }
}

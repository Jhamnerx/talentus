<?php

namespace App\Http\Livewire\Admin\Clientes\Contactos;

use App\Models\Contactos;
use Livewire\Component;

class ContactosIndex extends Component
{
    public $search;
    public $sort = "id";
    public $direction = "desc";


    public function render()
    {
        $contactos = Contactos::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })->orWhere('cargo', 'like', '%' . $this->search . '%')
            ->orWhere('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('telefono', 'like', '%' . $this->search . '%')
            ->orWhere('birthday', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        // ->get();
        return view('livewire.admin.clientes.contactos.contactos-index', compact('contactos'));
    }
}

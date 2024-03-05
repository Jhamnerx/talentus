<?php

namespace App\Livewire\Admin\Clientes\Contactos;

use App\Models\Contactos;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ContactosIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $sort = "id";
    public $direction = "desc";


    public function render()
    {
        $contactos = Contactos::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })->orWhere('cargo', 'like', '%' . $this->search . '%')
            ->orWhere('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('telefono', 'like', '%' . $this->search . '%')
            ->orWhere('numero_documento', 'like', '%' . $this->search . '%')
            ->orWhere('birthday', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')->with('clientes')
            ->orderBy('id', 'desc')
            ->paginate(10);
        // ->get();
        return view('livewire.admin.clientes.contactos.contactos-index', compact('contactos'));
    }


    public function openModalDelete(Contactos $contacto)
    {
        $this->dispatch('open-modal-delete', contacto: $contacto);
    }

    #[On('update-table')]
    public function updateTable()
    {

        $this->render();
        $this->resetPage();
    }
}

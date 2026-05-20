<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Clientes;
use App\Models\Contactos;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class VerContactos extends Component
{
    use WithPagination;

    public $modalOpen  = false;
    public $clienteId;
    public $clienteNombre;

    public function render()
    {
        $contactos = Contactos::where('clientes_id', $this->clienteId ?? 0)
            ->orderByDesc('is_gerente')
            ->orderBy('nombre')
            ->paginate(5);

        return view('livewire.admin.clientes.ver-contactos', compact('contactos'));
    }

    #[On('ver-contactos-cliente')]
    public function abrir(int $clienteId): void
    {
        $this->clienteId     = $clienteId;
        $this->clienteNombre = Clientes::find($clienteId)?->razon_social ?? '';
        $this->resetPage();
        $this->modalOpen = true;
    }

    public function cerrar(): void
    {
        $this->modalOpen     = false;
        $this->clienteId     = null;
        $this->clienteNombre = null;
        $this->resetPage();
    }
}

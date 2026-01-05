<?php

namespace App\Livewire\Admin\Contactos;

use App\Models\Contacto;
use Livewire\Component;
use Livewire\WithPagination;

class ContactosIndex extends Component
{
    use WithPagination;

    public $search;
    public $from = '';
    public $to = '';
    public $filtro_leido = 'todos';
    public $filtro_fecha = '0';

    protected $listeners = [
        'render' => 'render',
        'updateTable' => 'render',
    ];

    public function updatedFiltroFecha($value)
    {
        $this->filter((int)$value);
    }

    public function render()
    {
        $query = Contacto::query();

        // Búsqueda
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhere('company', 'like', '%' . $this->search . '%')
                    ->orWhere('message', 'like', '%' . $this->search . '%');
            });
        }

        // Filtro por fechas
        if (!empty($this->from) && !empty($this->to)) {
            $query->whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $this->from . " 00:00:00",
                    $this->to . " 23:59:59"
                ]
            );
        }

        // Filtro por estado leído
        if ($this->filtro_leido !== 'todos' && $this->filtro_leido !== '') {
            $query->where('leido', (bool)$this->filtro_leido);
        }

        $contactos = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.contactos.contactos-index', compact('contactos'));
    }

    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 7 days"));
                $this->to = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 month"));
                $this->to = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }

    public function openModalVer(Contacto $contacto)
    {
        $this->dispatch('verContacto', contactoId: $contacto->id);
    }

    public function toggleLeido(Contacto $contacto)
    {
        $this->dispatch('toggleLeido', contactoId: $contacto->id);
    }

    public function openModalDelete(Contacto $contacto)
    {
        $this->dispatch('deleteContacto', contactoId: $contacto->id);
    }
}

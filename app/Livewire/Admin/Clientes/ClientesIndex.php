<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Clientes;
use App\Models\Sector;
use Livewire\Component;
use Livewire\WithPagination;

class ClientesIndex extends Component
{
    use WithPagination;
    public $search;
    public $sector_id = '';
    public $from = '';
    public $to = '';
    public $modalOpenImport = false;

    protected $listeners = [
        'render' => 'render',
        'updateTable' => 'render',
        'update-table' => 'render',
        'echo:clientes,ClientesImportUpdated' => 'updateClientes'
    ];


    public function render()
    {
        $sectores = Sector::activos()->get(['id', 'nombre']);

        $clientes = Clientes::with(['sector', 'tipoDocumento'])
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';
                $query->where(function ($q) use ($search) {
                    $q->where('razon_social', 'like', $search)
                        ->orWhere('numero_documento', 'like', $search)
                        ->orWhere('email', 'like', $search)
                        ->orWhere('web_site', 'like', $search)
                        ->orWhere('direccion', 'like', $search)
                        ->orWhere('telefono', 'like', $search)
                        ->orWhereHas('tipoDocumento', fn ($t) => $t->where('descripcion', 'like', $search));
                });
            })
            ->when($this->sector_id, fn ($query) => $query->where('sector_id', $this->sector_id))
            ->when($this->from, function ($query) {
                $query->whereBetween('created_at', [$this->from . ' 00:00:00', $this->to . ' 23:59:59']);
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.admin.clientes.clientes-index', compact('clientes', 'sectores'));
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSectorId(): void
    {
        $this->resetPage();
    }

    public function updateClientes()
    {

        $this->render();
        $this->dispatch('clientes-import');
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
            case '12':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 year"));
                $this->to = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }

        $this->resetPage();
    }

    public function openModalImport()
    {

        $this->dispatch('openModalImport');
    }

    public function openModalSave()
    {
        $this->dispatch('open-modal-save-cliente');
    }

    public function openModalEdit(Clientes $cliente)
    {
        $this->dispatch('open-modal-edit', cliente: $cliente);
    }

    public function openModalDelete(Clientes $cliente)
    {
        $this->dispatch('abrir-modal-eliminar-cliente', cliente: $cliente);
    }

    public function verContactos(int $clienteId): void
    {
        $this->dispatch('ver-contactos-cliente', clienteId: $clienteId);
    }

    public function toggleStatus(Clientes $cliente)
    {
        $cliente->is_active = !$cliente->is_active; // Cambia el estado del toggle
        $cliente->save(); // Guarda el cambio en el modelo
    }
}

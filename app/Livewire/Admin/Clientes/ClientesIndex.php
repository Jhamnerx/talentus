<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Clientes;
use Livewire\Component;
use Livewire\WithPagination;

class ClientesIndex extends Component
{
    use WithPagination;
    public $search;
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
        $desde = $this->from;
        $hasta = $this->to;
        $clientes = Clientes::where('razon_social', 'like', '%' . $this->search . '%')
            ->orwhere('numero_documento', 'like', '%' . $this->search . '%')
            ->orwhere(
                function ($query) {
                    return $query
                        ->where('email', 'like', '%' . $this->search . '%')
                        ->orwhere('web_site', 'like', '%' . $this->search . '%')
                        ->orwhere('direccion', 'like', '%' . $this->search . '%')
                        ->orwhere('telefono', 'like', '%' . $this->search . '%');
                }
            )->orderBy('id', 'desc')
            ->paginate(10);

        if (!empty($desde)) {


            $clientes = Clientes::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(razon_social like ? OR numero_documento like ? OR web_site like ? OR email like ? OR telefono like ?)",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%'
                ]
            )
                ->orderBy('id', 'desc')
                ->paginate(10);
        }



        return view('livewire.admin.clientes.clientes-index', compact('clientes'));
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
    }

    public function openModalImport()
    {

        $this->dispatch('openModalImport');
    }

    public function openModalSave()
    {
        $this->dispatch('open-modal-save');
    }

    public function openModalEdit(Clientes $cliente)
    {
        $this->dispatch('open-modal-edit', cliente: $cliente);
    }
}

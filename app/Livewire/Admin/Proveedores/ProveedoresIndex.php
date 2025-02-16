<?php

namespace App\Livewire\Admin\Proveedores;

use App\Models\Proveedores;
use Livewire\Component;
use Livewire\WithPagination;

class ProveedoresIndex extends Component
{
    use WithPagination;

    public $search;
    public $from = '';
    public $to = '';

    protected $listeners = [
        'render' => 'render',
        'update-table' => 'render',
        'echo:proveedores,ProveedoresImportUpdated' => 'updateProveedores'
    ];

    public function updateProveedores()
    {
        $this->render();

        $this->dispatch('proveedores-import');
    }


    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;
        $proveedores = Proveedores::where('razon_social', 'like', '%' . $this->search . '%')
            ->orwhere('numero_documento', 'like', '%' . $this->search . '%')
            ->orwhere(
                function ($query) {
                    return $query
                        ->where('email', 'like', '%' . $this->search . '%')
                        ->orwhere('web_site', 'like', '%' . $this->search . '%')
                        ->orwhere('telefono', 'like', '%' . $this->search . '%');
                }
            )->orderBy('id', 'desc')
            ->paginate(10);

        if (!empty($desde)) {


            $proveedores = Proveedores::whereRaw(
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



        return view('livewire.admin.proveedores.proveedores-index', compact('proveedores'));
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

    public function openModalCreate()
    {
        $this->dispatch('open-modal-create');
    }

    public function openModalEdit(Proveedores $proveedor)
    {
        $this->dispatch('open-modal-edit', proveedor: $proveedor);
    }

    public function openModalDelete(Proveedores $proveedor)
    {
        $this->dispatch('open-modal-delete', proveedor: $proveedor);
    }
}

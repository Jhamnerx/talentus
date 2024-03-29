<?php

namespace App\Livewire\Admin\Dispositivos;

use App\Models\ModelosDispositivo;
use Livewire\Component;
use Livewire\WithPagination;

class ModelosDispositivosIndex extends Component
{
    use WithPagination;
    public $search;

    protected $listeners = [
        'ActualizarTabla' => 'render',
        'update-table' => 'render'
    ];

    public function render()
    {
        $modelos = ModelosDispositivo::where('modelo', 'like', '%' . $this->search . '%')
            ->orwhere('marca', 'like', '%' . $this->search . '%')
            ->orwhere(
                function ($query) {
                    return $query
                        ->where('certificado', 'like', '%' . $this->search . '%');
                }
            )
            ->paginate(10);

        return view('livewire.admin.dispositivos.modelos-dispositivos-index', compact('modelos'));
    }

    public function showModal(ModelosDispositivo $modelo)
    {
        $this->dispatch('abrirModal', $modelo);
    }

    public function openModalDelete(ModelosDispositivo $modelo)
    {
        $this->dispatch('open-modal-delete', modelo: $modelo);
    }
}

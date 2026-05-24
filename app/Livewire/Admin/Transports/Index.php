<?php

namespace App\Livewire\Admin\Transports;

use App\Models\Transport;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function render()
    {
        $transports = Transport::query()
            ->when($this->search, fn($q) => $q->where('placa', 'like', '%' . $this->search . '%')
                ->orWhere('marca', 'like', '%' . $this->search . '%')
                ->orWhere('modelo', 'like', '%' . $this->search . '%'))
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.admin.transports.index', compact('transports'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[On('transport-saved')]
    public function refreshTable(): void {}

    public function openModalCreate(): void
    {
        $this->dispatch('open-modal-create-transport');
    }

    public function openModalEdit(Transport $transport): void
    {
        $this->dispatch('open-modal-edit-transport', transport: $transport);
    }

    public function delete(Transport $transport): void
    {
        $transport->delete();
        $this->dispatch('transport-saved');
    }
}

<?php

namespace App\Livewire\Admin\Dispatchers;

use App\Models\Dispatcher;
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
        $dispatchers = Dispatcher::query()
            ->when($this->search, fn($q) => $q->where('razon_social', 'like', '%' . $this->search . '%')
                ->orWhere('numero_doc', 'like', '%' . $this->search . '%'))
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.admin.dispatchers.index', compact('dispatchers'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[On('dispatcher-saved')]
    public function refreshTable(): void {}

    public function openModalCreate(): void
    {
        $this->dispatch('open-modal-create-dispatcher');
    }

    public function openModalEdit(Dispatcher $dispatcher): void
    {
        $this->dispatch('open-modal-edit-dispatcher', dispatcher: $dispatcher);
    }

    public function delete(Dispatcher $dispatcher): void
    {
        $dispatcher->delete();
        $this->dispatch('dispatcher-saved');
    }
}

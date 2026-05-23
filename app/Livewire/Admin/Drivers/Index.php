<?php

namespace App\Livewire\Admin\Drivers;

use App\Models\Driver;
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
        $drivers = Driver::query()
            ->when($this->search, fn($q) => $q->where('nombres', 'like', '%' . $this->search . '%')
                ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                ->orWhere('numero_doc', 'like', '%' . $this->search . '%'))
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.admin.drivers.index', compact('drivers'));
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[On('driver-saved')]
    public function refreshTable(): void {}

    public function openModalCreate(): void
    {
        $this->dispatch('open-modal-create-driver');
    }

    public function openModalEdit(Driver $driver): void
    {
        $this->dispatch('open-modal-edit-driver', driver: $driver);
    }

    public function delete(Driver $driver): void
    {
        $driver->delete();
        $this->dispatch('driver-saved');
    }
}

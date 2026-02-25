<?php

namespace App\Livewire\Admin\Planes;

use App\Models\Plan;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $planes = Plan::query()
            ->with(['producto', 'features'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('slug', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.planes.index', [
            'planes' => $planes
        ]);
    }

    #[On('plan-saved')]
    public function refreshTable()
    {
        $this->resetPage();
        $this->dispatch('$refresh');
    }

    // ============ MODAL CREATE ============
    public function openModalCreate()
    {
        $this->dispatch('open-modal-create-plan');
    }

    // ============ MODAL EDIT ============
    public function openModalEdit(Plan $plan)
    {
        $this->dispatch('open-modal-edit-plan', plan: $plan);
    }

    // ============ MODAL DELETE ============
    public function openModalDelete(Plan $plan)
    {
        $this->dispatch('open-modal-delete-plan', plan: $plan);
    }

    // ============ MODAL FEATURES ============
    public function openModalFeatures(Plan $plan)
    {
        $this->dispatch('open-modal-features', plan: $plan);
    }
}

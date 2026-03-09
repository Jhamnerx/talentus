<?php

namespace App\Livewire\Admin\Ajustes\Banks;

use App\Models\Bank;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['render'];

    public function render()
    {
        $banks = Bank::where('description', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.admin.ajustes.banks.index', compact('banks'));
    }

    public function create()
    {
        $this->dispatch('open-bank-modal', id: null);
    }

    public function edit($id)
    {
        $this->dispatch('open-bank-modal', id: $id);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirm-delete-bank', id: $id);
    }

    public function delete($id)
    {
        $bank = Bank::find($id);
        if ($bank) {
            $bank->delete();
            $this->dispatch('render');
        }
    }
}

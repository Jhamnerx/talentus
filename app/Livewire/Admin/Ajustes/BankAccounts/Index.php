<?php

namespace App\Livewire\Admin\Ajustes\BankAccounts;

use App\Models\Bank;
use App\Models\BankAccount;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WithPagination, WireUiActions;

    public $search = '';
    public $bank_filter = '';
    public $currency_filter = '';
    public $status_filter = '';

    protected $listeners = ['render'];

    public function render()
    {
        $query = BankAccount::with(['bank'])
            ->where('description', 'like', "%{$this->search}%")
            ->when($this->bank_filter, fn($q) => $q->where('bank_id', $this->bank_filter))
            ->when($this->currency_filter, fn($q) => $q->where('currency_type_id', $this->currency_filter))
            ->when($this->status_filter !== '', fn($q) => $q->where('status', $this->status_filter))
            ->orderBy('description')
            ->paginate(10);

        $banks = Bank::active()->orderBy('description')->get();
        $currencies = collect([
            (object)['id' => 'PEN', 'description' => 'Soles (PEN)'],
            (object)['id' => 'USD', 'description' => 'Dólares (USD)'],
        ]);

        return view('livewire.admin.ajustes.bank-accounts.index', [
            'bankAccounts' => $query,
            'banks' => $banks,
            'currencies' => $currencies,
        ]);
    }

    public function create()
    {
        $this->dispatch('open-account-modal');
    }

    public function edit($id)
    {
        $this->dispatch('edit-account-modal', id: $id);
    }

    public function toggleStatus($id)
    {
        $account = BankAccount::find($id);
        if ($account) {
            $account->status = !$account->status;
            $account->save();
            $this->notification()->success(
                title: 'Estado actualizado',
                description: $account->status ? 'Cuenta activada' : 'Cuenta desactivada'
            );
            $this->dispatch('render');
        }
    }

    public function toggleShowInDocuments($id)
    {
        $account = BankAccount::find($id);
        if ($account) {
            $account->show_in_documents = !$account->show_in_documents;
            $account->save();
            $this->notification()->success(
                title: 'Visibilidad actualizada',
                description: $account->show_in_documents ? 'Visible en documentos' : 'Oculta en documentos'
            );
            $this->dispatch('render');
        }
    }

    public function confirmDelete($id)
    {
        $this->dialog()->confirm([
            'title' => '¿Estás seguro?',
            'description' => 'Esta acción eliminará la cuenta bancaria permanentemente',
            'acceptLabel' => 'Sí, eliminar',
            'rejectLabel' => 'Cancelar',
            'method' => 'delete',
            'params' => $id,
        ]);
    }

    public function delete($id)
    {
        $account = BankAccount::find($id);
        if ($account) {
            $account->delete();
            $this->notification()->success(
                title: 'Cuenta eliminada',
                description: 'La cuenta bancaria ha sido eliminada correctamente'
            );
            $this->dispatch('render');
        }
    }
}

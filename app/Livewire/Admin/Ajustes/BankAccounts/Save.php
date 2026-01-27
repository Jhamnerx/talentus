<?php

namespace App\Livewire\Admin\Ajustes\BankAccounts;

use App\Models\Bank;
use App\Models\BankAccount;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class Save extends Component
{
    use WireUiActions;

    public $showModal = false;
    public $bank_account_id;
    public $bank_id = '';
    public $description = '';
    public $number = '';
    public $cci = '';
    public $currency_type_id = 'PEN';
    public $initial_balance = 0.00;
    public $show_in_documents = true;

    protected $rules = [
        'bank_id' => 'required|exists:banks,id',
        'description' => 'required|string|max:255',
        'number' => 'required|string|max:255',
        'cci' => 'nullable|string|max:255',
        'currency_type_id' => 'required|in:PEN,USD',
        'initial_balance' => 'required|numeric|min:0',
        'show_in_documents' => 'boolean',
    ];

    protected $messages = [
        'bank_id.required' => 'Seleccione un banco',
        'description.required' => 'La descripción es obligatoria',
        'number.required' => 'El número de cuenta es obligatorio',
        'currency_type_id.required' => 'Seleccione una moneda',
        'initial_balance.required' => 'El saldo inicial es obligatorio',
    ];

    #[On('open-bank-account-modal')]
    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->bank_account_id = $id;

        if ($id) {
            $bankAccount = BankAccount::find($id);
            if ($bankAccount) {
                $this->bank_id = $bankAccount->bank_id;
                $this->description = $bankAccount->description;
                $this->number = $bankAccount->number;
                $this->cci = $bankAccount->cci;
                $this->currency_type_id = $bankAccount->currency_type_id;
                $this->initial_balance = $bankAccount->initial_balance;
                $this->show_in_documents = $bankAccount->show_in_documents;
            }
        } else {
            $this->reset(['bank_id', 'description', 'number', 'cci', 'initial_balance']);
            $this->currency_type_id = 'PEN';
            $this->show_in_documents = true;
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'bank_id' => $this->bank_id,
            'description' => $this->description,
            'number' => $this->number,
            'cci' => $this->cci,
            'currency_type_id' => $this->currency_type_id,
            'initial_balance' => $this->initial_balance,
            'show_in_documents' => $this->show_in_documents,
            'status' => true,
        ];

        if ($this->bank_account_id) {
            $bankAccount = BankAccount::find($this->bank_account_id);
            $bankAccount->update($data);
            $message = 'Cuenta bancaria actualizada correctamente';
        } else {
            BankAccount::create($data);
            $message = 'Cuenta bancaria creada correctamente';
        }

        $this->notification()->success(
            title: '¡Éxito!',
            description: $message
        );

        $this->dispatch('render')->to(Index::class);
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['bank_account_id', 'bank_id', 'description', 'number', 'cci', 'currency_type_id', 'initial_balance', 'show_in_documents']);
    }

    public function render()
    {
        $banks = Bank::active()->orderBy('description')->get();
        $currencies = collect([
            (object)['id' => 'PEN', 'name' => 'Soles (PEN)'],
            (object)['id' => 'USD', 'name' => 'Dólares (USD)'],
        ]);

        return view('livewire.admin.ajustes.bank-accounts.save', [
            'banks' => $banks,
            'currencies' => $currencies,
        ]);
    }
}

<?php

namespace App\Livewire\Admin\Ajustes\Banks;

use App\Models\Bank;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class Save extends Component
{
    use WireUiActions;

    public $showModal = false;
    public $bank_id;
    public $description = '';

    protected $rules = [
        'description' => 'required|string|max:255',
    ];

    protected $messages = [
        'description.required' => 'La descripción es obligatoria',
    ];

    #[On('open-bank-modal')]
    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->bank_id = $id;

        if ($id) {
            $bank = Bank::find($id);
            if ($bank) {
                $this->description = $bank->description;
            }
        } else {
            $this->reset(['description']);
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->bank_id) {
            $bank = Bank::find($this->bank_id);
            $bank->update(['description' => $this->description]);
            $message = 'Banco actualizado correctamente';
        } else {
            Bank::create([
                'description' => $this->description,
                'active' => true,
            ]);
            $message = 'Banco creado correctamente';
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
        $this->reset(['bank_id', 'description']);
    }

    public function render()
    {
        return view('livewire.admin.ajustes.banks.save');
    }
}

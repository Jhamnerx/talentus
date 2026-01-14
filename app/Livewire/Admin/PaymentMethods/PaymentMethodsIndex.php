<?php

namespace App\Livewire\Admin\PaymentMethods;

use App\Models\PaymentMethodType;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class PaymentMethodsIndex extends Component
{
    use WithPagination, WireUiActions;

    public $search;
    public $editingId = null;
    public $description;
    public $active;

    protected $listeners = [
        'render' => 'render',
    ];

    public function render()
    {
        $paymentMethods = PaymentMethodType::query()
            ->when($this->search, function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(20);

        return view('livewire.admin.payment-methods.payment-methods-index', compact('paymentMethods'));
    }

    public function edit($id)
    {
        $method = PaymentMethodType::find($id);
        $this->editingId = $id;
        $this->description = $method->description;
        $this->active = $method->active;
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->reset(['description', 'active']);
    }

    public function update()
    {
        $this->validate([
            'description' => 'required|string|max:255',
            'active' => 'required|boolean',
        ]);

        try {
            $method = PaymentMethodType::find($this->editingId);
            $method->update([
                'description' => $this->description,
                'active' => $this->active,
            ]);

            $this->cancelEdit();
            $this->notification()->success('Método de pago actualizado correctamente');
        } catch (\Throwable $th) {
            $this->notification()->error('Error al actualizar: ' . $th->getMessage());
        }
    }

    public function toggleActive($id)
    {
        try {
            $method = PaymentMethodType::find($id);
            $method->update(['active' => !$method->active]);
            $this->notification()->success('Estado actualizado correctamente');
            $this->render();
        } catch (\Throwable $th) {
            $this->notification()->error('Error: ' . $th->getMessage());
        }
    }
}

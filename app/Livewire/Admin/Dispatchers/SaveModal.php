<?php

namespace App\Livewire\Admin\Dispatchers;

use App\Models\Dispatcher;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class SaveModal extends Component
{
    use WireUiActions;

    public bool $modalOpen = false;
    public ?Dispatcher $dispatcher = null;
    public string $tipo_doc = '6';
    public string $numero_doc = '';
    public string $razon_social = '';
    public string $address = '';
    public string $numero_mtc = '';
    public bool $is_active = true;

    protected function rules(): array
    {
        return [
            'tipo_doc'     => 'required',
            'numero_doc'   => 'required',
            'razon_social' => 'required',
            'address'      => 'nullable',
            'numero_mtc'   => 'nullable',
            'is_active'    => 'boolean',
        ];
    }

    public function render()
    {
        return view('livewire.admin.dispatchers.save-modal');
    }

    #[On('open-modal-create-dispatcher')]
    public function openCreate(): void
    {
        $this->resetValidation();
        $this->reset(['dispatcher', 'tipo_doc', 'numero_doc', 'razon_social', 'address', 'numero_mtc', 'is_active']);
        $this->is_active = true;
        $this->tipo_doc = '6';
        $this->modalOpen = true;
    }

    #[On('open-modal-edit-dispatcher')]
    public function openEdit(Dispatcher $dispatcher): void
    {
        $this->resetValidation();
        $this->dispatcher   = $dispatcher;
        $this->tipo_doc     = $dispatcher->tipo_doc;
        $this->numero_doc   = $dispatcher->numero_doc;
        $this->razon_social = $dispatcher->razon_social;
        $this->address      = $dispatcher->address ?? '';
        $this->numero_mtc   = $dispatcher->numero_mtc ?? '';
        $this->is_active    = (bool) $dispatcher->is_active;
        $this->modalOpen    = true;
    }

    public function save(): void
    {
        $datos = $this->validate();

        try {
            if ($this->dispatcher) {
                $this->dispatcher->update($datos);
                $msg = 'Transportista actualizado correctamente';
            } else {
                Dispatcher::create($datos);
                $msg = 'Transportista registrado correctamente';
            }
            $this->modalOpen = false;
            $this->notification()->success(title: 'TRANSPORTISTA', description: $msg);
            $this->dispatch('dispatcher-saved');
        } catch (\Throwable $th) {
            $this->notification()->error(title: 'ERROR', description: $th->getMessage());
        }
    }
}

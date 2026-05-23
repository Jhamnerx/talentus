<?php

namespace App\Livewire\Admin\Transports;

use App\Models\Transport;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class SaveModal extends Component
{
    use WireUiActions;

    public bool $modalOpen = false;
    public ?Transport $transport = null;
    public string $placa = '';
    public string $marca = '';
    public string $modelo = '';
    public bool $is_active = true;

    protected function rules(): array
    {
        return [
            'placa'     => 'required|max:10',
            'marca'     => 'nullable',
            'modelo'    => 'nullable',
            'is_active' => 'boolean',
        ];
    }

    public function render()
    {
        return view('livewire.admin.transports.save-modal');
    }

    #[On('open-modal-create-transport')]
    public function openCreate(): void
    {
        $this->resetValidation();
        $this->reset(['transport', 'placa', 'marca', 'modelo', 'is_active']);
        $this->is_active = true;
        $this->modalOpen = true;
    }

    #[On('open-modal-edit-transport')]
    public function openEdit(Transport $transport): void
    {
        $this->resetValidation();
        $this->transport = $transport;
        $this->placa     = $transport->placa;
        $this->marca     = $transport->marca ?? '';
        $this->modelo    = $transport->modelo ?? '';
        $this->is_active = (bool) $transport->is_active;
        $this->modalOpen = true;
    }

    public function save(): void
    {
        $datos = $this->validate();

        try {
            if ($this->transport) {
                $this->transport->update($datos);
                $msg = 'Vehículo actualizado correctamente';
            } else {
                Transport::create($datos);
                $msg = 'Vehículo registrado correctamente';
            }
            $this->modalOpen = false;
            $this->notification()->success(title: 'VEHÍCULO', description: $msg);
            $this->dispatch('transport-saved');
        } catch (\Throwable $th) {
            $this->notification()->error(title: 'ERROR', description: $th->getMessage());
        }
    }
}

<?php

namespace App\Livewire\Admin\Drivers;

use App\Models\Driver;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class SaveModal extends Component
{
    use WireUiActions;

    public bool $modalOpen = false;
    public ?Driver $driver = null;
    public string $tipo_doc = '1';
    public string $numero_doc = '';
    public string $nombres = '';
    public string $apellidos = '';
    public string $licencia = '';
    public bool $is_active = true;

    protected function rules(): array
    {
        return [
            'tipo_doc'   => 'required',
            'numero_doc' => 'required',
            'nombres'    => 'required',
            'apellidos'  => 'nullable',
            'licencia'   => 'nullable',
            'is_active'  => 'boolean',
        ];
    }

    public function render()
    {
        return view('livewire.admin.drivers.save-modal');
    }

    #[On('open-modal-create-driver')]
    public function openCreate(): void
    {
        $this->resetValidation();
        $this->reset(['driver', 'tipo_doc', 'numero_doc', 'nombres', 'apellidos', 'licencia', 'is_active']);
        $this->is_active = true;
        $this->tipo_doc = '1';
        $this->modalOpen = true;
    }

    #[On('open-modal-edit-driver')]
    public function openEdit(Driver $driver): void
    {
        $this->resetValidation();
        $this->driver     = $driver;
        $this->tipo_doc   = $driver->tipo_doc;
        $this->numero_doc = $driver->numero_doc;
        $this->nombres    = $driver->nombres;
        $this->apellidos  = $driver->apellidos ?? '';
        $this->licencia   = $driver->licencia ?? '';
        $this->is_active  = (bool) $driver->is_active;
        $this->modalOpen  = true;
    }

    public function save(): void
    {
        $datos = $this->validate();

        try {
            if ($this->driver) {
                $this->driver->update($datos);
                $msg = 'Conductor actualizado correctamente';
            } else {
                Driver::create($datos);
                $msg = 'Conductor registrado correctamente';
            }
            $this->modalOpen = false;
            $this->notification()->success(title: 'CONDUCTOR', description: $msg);
            $this->dispatch('driver-saved');
        } catch (\Throwable $th) {
            $this->notification()->error(title: 'ERROR', description: $th->getMessage());
        }
    }
}

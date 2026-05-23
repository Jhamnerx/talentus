<?php

namespace App\Livewire\Admin\Drivers;

use App\Models\Driver;
use App\Services\FactilizaService;
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
    public string $name = '';
    public string $licencia = '';
    public string $telephone = '';
    public bool $is_default = false;
    public bool $is_active = true;
    public bool $buscando = false;

    protected function rules(): array
    {
        return [
            'tipo_doc'   => 'required',
            'numero_doc' => 'required',
            'name'       => 'required',
            'licencia'   => 'nullable',
            'telephone'  => 'nullable',
            'is_default' => 'boolean',
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
        $this->reset(['driver', 'tipo_doc', 'numero_doc', 'name', 'licencia', 'telephone', 'is_default', 'is_active', 'buscando']);
        $this->is_active = true;
        $this->tipo_doc  = '1';
        $this->modalOpen = true;
    }

    #[On('open-modal-edit-driver')]
    public function openEdit(Driver $driver): void
    {
        $this->resetValidation();
        $this->driver     = $driver;
        $this->tipo_doc   = $driver->tipo_doc;
        $this->numero_doc = $driver->numero_doc;
        $this->name       = $driver->name ?? '';
        $this->licencia   = $driver->licencia ?? '';
        $this->telephone  = $driver->telephone ?? '';
        $this->is_default = (bool) $driver->is_default;
        $this->is_active  = (bool) $driver->is_active;
        $this->modalOpen  = true;
    }

    public function searchDni(): void
    {
        $this->validate(['numero_doc' => 'required|digits:8']);
        $this->buscando = true;

        try {
            $data = app(FactilizaService::class)->consultarDni($this->numero_doc);

            $nombres   = $data['nombres'] ?? '';
            $aPaterno  = $data['apellido_paterno'] ?? '';
            $aMaterno  = $data['apellido_materno'] ?? '';
            $this->name = trim("{$aPaterno} {$aMaterno} {$nombres}");
        } catch (\Throwable) {
            $this->notification()->error(title: 'RENIEC', description: 'No se encontró el DNI o hubo un error al consultarlo.');
        } finally {
            $this->buscando = false;
        }
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

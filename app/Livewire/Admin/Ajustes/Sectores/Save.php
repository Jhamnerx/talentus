<?php

namespace App\Livewire\Admin\Ajustes\Sectores;

use App\Models\Sector;
use Livewire\Component;

class Save extends Component
{
    public bool   $openModal   = false;
    public string $nombre      = '';
    public string $descripcion = '';
    public int    $orden       = 0;
    public bool   $is_active   = true;

    protected $listeners = ['openModalSaveSector' => 'open'];

    public function open(): void
    {
        $this->reset();
        $this->is_active = true;
        $this->openModal = true;
    }

    public function close(): void
    {
        $this->openModal = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function rules(): array
    {
        return [
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'orden'       => 'integer|min:0',
            'is_active'   => 'boolean',
        ];
    }

    public function save(): void
    {
        $values = $this->validate();
        $values['empresa_id'] = session('empresa');

        Sector::create($values);

        $this->dispatch('notify-toast', icon: 'success', title: 'SECTOR CREADO', mensaje: 'Se creó el sector: ' . $this->nombre);
        $this->dispatch('update-table');
        $this->close();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.sectores.save');
    }
}

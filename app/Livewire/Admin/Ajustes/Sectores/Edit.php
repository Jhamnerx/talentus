<?php

namespace App\Livewire\Admin\Ajustes\Sectores;

use App\Models\Sector;
use Livewire\Component;

class Edit extends Component
{
    public bool    $openModal   = false;
    public ?Sector $sector      = null;
    public string  $nombre      = '';
    public string  $descripcion = '';
    public int     $orden       = 0;
    public bool    $is_active   = true;

    protected $listeners = ['openModalEditSector' => 'open'];

    public function open(Sector $sector): void
    {
        $this->sector      = $sector;
        $this->nombre      = $sector->nombre;
        $this->descripcion = $sector->descripcion ?? '';
        $this->orden       = $sector->orden;
        $this->is_active   = $sector->is_active;
        $this->openModal   = true;
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

    public function update(): void
    {
        $values = $this->validate();
        $this->sector->update($values);

        $this->dispatch('notify-toast', icon: 'success', title: 'SECTOR ACTUALIZADO', mensaje: 'Se actualizó el sector: ' . $this->nombre);
        $this->dispatch('update-table');
        $this->close();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.sectores.edit');
    }
}

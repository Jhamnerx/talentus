<?php

namespace App\Livewire\Admin\Ajustes\Rubros;

use App\Models\RubroCliente;
use Livewire\Component;

class Edit extends Component
{
    public bool          $openModal   = false;
    public ?RubroCliente $rubro       = null;
    public string        $nombre      = '';
    public string        $descripcion = '';
    public bool          $is_active   = true;

    protected $listeners = ['openModalEditRubro' => 'open'];

    public function open(RubroCliente $rubro): void
    {
        $this->rubro       = $rubro;
        $this->nombre      = $rubro->nombre;
        $this->descripcion = $rubro->descripcion ?? '';
        $this->is_active   = $rubro->is_active;
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
            'is_active'   => 'boolean',
        ];
    }

    public function update(): void
    {
        $values = $this->validate();
        $this->rubro->update($values);

        $this->dispatch('notify-toast', icon: 'success', title: 'RUBRO ACTUALIZADO', mensaje: 'Se actualizó el rubro: ' . $this->nombre);
        $this->dispatch('update-table');
        $this->close();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.rubros.edit');
    }
}

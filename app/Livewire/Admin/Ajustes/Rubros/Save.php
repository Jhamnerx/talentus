<?php

namespace App\Livewire\Admin\Ajustes\Rubros;

use App\Models\RubroCliente;
use Livewire\Component;

class Save extends Component
{
    public bool   $openModal   = false;
    public string $nombre      = '';
    public string $descripcion = '';
    public bool   $is_active   = true;

    protected $listeners = ['openModalSaveRubro' => 'open'];

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
            'is_active'   => 'boolean',
        ];
    }

    public function save(): void
    {
        $values = $this->validate();
        $values['empresa_id'] = session('empresa');

        RubroCliente::create($values);

        $this->dispatch('notify-toast', icon: 'success', title: 'RUBRO CREADO', mensaje: 'Se creó el rubro: ' . $this->nombre);
        $this->dispatch('update-table');
        $this->close();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.rubros.save');
    }
}

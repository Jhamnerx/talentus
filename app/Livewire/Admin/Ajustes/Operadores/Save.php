<?php

namespace App\Livewire\Admin\Ajustes\Operadores;

use App\Models\Operador;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Save extends Component
{
    use WireUiActions;
    public bool $openModalSave = false;

    public string $name = '';
    public bool $have_api = false;
    public string $api_slug = '';

    protected $listeners = ['openModalSave' => 'openModal'];

    protected function rules(): array
    {
        return [
            'name'     => 'required|string|max:100|unique:operadores,name',
            'have_api' => 'boolean',
            'api_slug' => 'nullable|string|max:100',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'El nombre del operador es requerido.',
            'name.unique'   => 'Ya existe un operador con ese nombre.',
        ];
    }

    public function openModal(): void
    {
        $this->openModalSave = true;
    }

    public function closeModal(): void
    {
        $this->openModalSave = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.operadores.save');
    }

    public function updated(string $field): void
    {
        $this->validateOnly($field);
    }

    public function save(): void
    {
        $values = $this->validate();

        Operador::create($values);

        $this->notification()->success('OPERADOR CREADO', 'Se creó el operador: ' . $this->name);
        $this->dispatch('update-table');
        $this->closeModal();
    }
}

<?php

namespace App\Livewire\Admin\Ajustes\Operadores;

use App\Models\Operador;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Edit extends Component
{
    use WireUiActions;
    public bool $openModalEdit = false;

    public Operador $operador;
    public string $name = '';
    public bool $have_api = false;
    public string $api_slug = '';

    protected $listeners = ['openModalEdit' => 'openModal'];

    protected function rules(): array
    {
        return [
            'name'     => "required|string|max:100|unique:operadores,name,{$this->operador->id}",
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

    public function openModal(Operador $operador): void
    {
        $this->openModalEdit = true;
        $this->operador      = $operador;
        $this->name          = $operador->name;
        $this->have_api      = $operador->have_api;
        $this->api_slug      = $operador->api_slug ?? '';
    }

    public function closeModal(): void
    {
        $this->openModalEdit = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.operadores.edit');
    }

    public function updated(string $field): void
    {
        $this->validateOnly($field);
    }

    public function update(): void
    {
        $values = $this->validate();

        $this->operador->update($values);

        $this->notification()->success('OPERADOR ACTUALIZADO', 'Se actualizó: ' . $this->name);
        $this->dispatch('update-table');
        $this->closeModal();
    }
}

<?php

namespace App\Livewire\Admin\WhatsFleep\Contacts;

use App\Models\WhatsFleep\Contact;
use App\Models\WhatsFleep\WaTag;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Create extends Component
{
    use WireUiActions;

    public string $name     = '';
    public string $number   = '';
    public string $tag_id   = '';
    public bool   $showModal = false;

    protected $listeners = ['open-create-contact-modal' => 'openModal'];

    protected function rules(): array
    {
        return [
            'name'   => 'nullable|string|max:255',
            'number' => 'required|string|max:20',
            'tag_id' => 'required|exists:tags,id',
        ];
    }

    protected function messages(): array
    {
        return [
            'number.required' => 'El número de WhatsApp es obligatorio',
            'tag_id.required' => 'Debes seleccionar un grupo',
            'tag_id.exists'   => 'El grupo seleccionado no existe',
        ];
    }

    public function openModal(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $validated = $this->validate();

        $tag = WaTag::where('id', $validated['tag_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $exists = Contact::where('user_id', Auth::id())
            ->where('number', $validated['number'])
            ->where('tag_id', $tag->id)
            ->exists();

        if ($exists) {
            $this->notification()->error(
                title: '¡Error!',
                description: 'Este contacto ya existe en el grupo seleccionado'
            );
            return;
        }

        Contact::create([
            'user_id' => Auth::id(),
            'tag_id'  => $tag->id,
            'name'    => $validated['name'],
            'number'  => $validated['number'],
        ]);

        $this->dispatch('contactCreated');
        $this->closeModal();
    }

    private function resetForm(): void
    {
        $this->name   = '';
        $this->number = '';
        $this->tag_id = '';
        $this->resetValidation();
    }

    public function render()
    {
        $tags = Auth::user()->waTags()->get();

        return view('livewire.admin.whats-fleep.contacts.create', compact('tags'));
    }
}

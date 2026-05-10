<?php

namespace App\Livewire\Admin\WhatsFleep\Contacts;

use App\Models\WhatsFleep\WaTag;
use App\Imports\WhatsFleep\ContactsImport;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use WireUi\Traits\WireUiActions;

class ImportCsv extends Component
{
    use WireUiActions, WithFileUploads;

    public $file;
    public string $tag_id   = '';
    public bool   $showModal = false;

    protected $listeners = ['open-import-contacts-modal' => 'openModal'];

    protected function rules(): array
    {
        return [
            'file'   => 'required|file|mimes:xlsx,xls,csv|max:10240',
            'tag_id' => 'required|exists:tags,id',
        ];
    }

    public function openModal(): void
    {
        $this->reset(['file', 'tag_id']);
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['file', 'tag_id']);
    }

    public function import(): void
    {
        $validated = $this->validate();

        $tag = WaTag::where('id', $validated['tag_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        try {
            $import = new ContactsImport($tag, Auth::id());
            Excel::import($import, $this->file);

            $this->dispatch('contactsImported', count: $import->getRowCount());
            $this->closeModal();
        } catch (\Exception $e) {
            $this->notification()->error(
                title: '¡Error!',
                description: 'Error al importar: ' . $e->getMessage()
            );
        }
    }

    public function render()
    {
        $tags = Auth::user()->waTags()->get();

        return view('livewire.admin.whats-fleep.contacts.import-csv', compact('tags'));
    }
}

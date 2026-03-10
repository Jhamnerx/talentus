<x-admin-layout>

    @livewire('admin.items.index', ['tipo' => $tipo], key('productos-index-' . $tipo))

    @livewire('admin.items.create-modal', [], key('create-producto-modal-' . $tipo))
    @livewire('admin.items.edit-modal', [], key('edit-producto-modal-' . $tipo))
    @livewire('admin.items.delete-modal', [], key('delete-producto-modal-' . $tipo))


</x-admin-layout>

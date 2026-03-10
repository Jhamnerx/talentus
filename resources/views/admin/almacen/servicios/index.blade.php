<x-admin-layout>

    @livewire('admin.items.index', ['tipo' => $tipo], key('productos-index-' . $tipo))

    @livewire('admin.items.create-modal')
    @livewire('admin.items.edit-modal')
    @livewire('admin.items.delete-modal')

</x-admin-layout>

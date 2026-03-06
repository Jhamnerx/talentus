<x-admin-layout>

    @livewire('admin.productos.index', ['tipo' => $tipo], key('productos-index-' . $tipo))

    @livewire('admin.productos.create-modal')
    @livewire('admin.productos.edit-modal')
    @livewire('admin.productos.delete-modal')

</x-admin-layout>

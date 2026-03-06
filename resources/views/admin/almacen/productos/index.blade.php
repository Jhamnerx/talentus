<x-admin-layout>

    @livewire('admin.productos.index', ['tipo' => $tipo], key('productos-index-' . $tipo))

    @livewire('admin.productos.create-modal', [], key('create-producto-modal-' . $tipo))
    @livewire('admin.productos.edit-modal', [], key('edit-producto-modal-' . $tipo))
    @livewire('admin.productos.delete-modal', [], key('delete-producto-modal-' . $tipo))


</x-admin-layout>

<x-admin-layout>

    <!-- Table -->
    @livewire('admin.productos.productos-index', ['tipo' => $tipo])

    @livewire('admin.productos.create-modal')
    @livewire('admin.productos.edit-modal')
    @livewire('admin.productos.delete-modal')

</x-admin-layout>

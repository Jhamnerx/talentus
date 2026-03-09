<x-admin-layout>

    <!-- Planes Management -->
    @livewire('admin.planes.index')

    <!-- Modals -->
    @livewire('admin.planes.create-modal')
    @livewire('admin.planes.edit-modal')
    @livewire('admin.planes.delete-modal')
    @livewire('admin.planes.features-modal')

</x-admin-layout>

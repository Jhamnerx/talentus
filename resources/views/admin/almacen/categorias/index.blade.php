<x-admin-layout>

    <!-- Table -->
    @livewire('admin.categorias.index')

    @livewire('admin.categorias.create-modal')
    @livewire('admin.categorias.edit-modal')
    @livewire('admin.categorias.delete-modal')

</x-admin-layout>

@push('modals')
@endpush

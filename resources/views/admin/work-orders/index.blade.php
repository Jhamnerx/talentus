<x-admin-layout>
    @livewire('admin.work-orders.index')

    {{-- Modales globales --}}
    @livewire('admin.work-orders.create-modal')
    @livewire('admin.work-orders.edit-modal')
    @livewire('admin.work-orders.export-modal')
    @livewire('admin.work-orders.quick-add-vehiculo')
</x-admin-layout>

<x-admin-layout>
    @livewire('admin.work-orders.index')

    {{-- Modales globales --}}
    @livewire('admin.work-orders.create-modal')
    @livewire('admin.work-orders.export-modal')
</x-admin-layout>

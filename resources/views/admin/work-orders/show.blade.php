<x-admin-layout>
    @livewire('admin.work-orders.show', ['workOrder' => $workOrder])

    {{-- Modales globales --}}
    @livewire('admin.work-orders.export-modal')
</x-admin-layout>

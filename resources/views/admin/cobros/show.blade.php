<x-admin-layout>

    @livewire('admin.cobros.show', ['cobro' => $cobro])

    @livewire('admin.cobros.payment')
    @livewire('admin.cobros.modal-suspend')
    @livewire('admin.cobros.modal-activar')

</x-admin-layout>

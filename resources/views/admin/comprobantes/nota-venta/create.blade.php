<x-admin-layout>

    @livewire('admin.facturacion.ventas.emitir', ['comprobante_slug' => Request::segment(2)])

    @livewire('admin.items.create-modal')
    @livewire('admin.items.modal-add-producto')

</x-admin-layout>

<x-admin-layout>

    @livewire('admin.facturacion.ventas.emitir', ['comprobante_slug' => Request::segment(3)])

    @livewire('admin.productos.create-modal')
    @livewire('admin.productos.modal-add-producto')

</x-admin-layout>

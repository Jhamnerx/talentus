<x-admin-layout>

    @livewire('admin.facturacion.ventas.emitir', [
        'comprobante_slug' => Request::segment(2),
        'notificacion_ids' => $notificacion_ids,
    ])

    @livewire('admin.items.create-modal')
    @livewire('admin.clientes.save')
    @livewire('admin.facturacion.ventas.modal-detraccion')

</x-admin-layout>

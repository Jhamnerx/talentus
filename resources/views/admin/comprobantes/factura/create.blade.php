<x-admin-layout>

    @livewire('admin.facturacion.ventas.emitir', [
        'comprobante_slug' => Request::segment(3),
        'detalle_ids' => $detalle_ids,
        'cobro_id' => $cobro_id,
    ])

    @livewire('admin.productos.create-modal')
    @livewire('admin.clientes.save')
    @livewire('admin.facturacion.ventas.modal-detraccion')

</x-admin-layout>

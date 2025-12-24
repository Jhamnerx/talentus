<x-admin-layout ruta="ventas-recibos">

    @livewire('admin.ventas.recibos.create', [
        'detalle_ids' => $detalle_ids,
        'cobro_id' => $cobro_id,
    ])

    @livewire('admin.clientes.save')
    @livewire('admin.productos.create-modal')

</x-admin-layout>

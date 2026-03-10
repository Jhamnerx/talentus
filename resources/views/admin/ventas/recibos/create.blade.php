<x-admin-layout ruta="ventas-recibos">

    @livewire('admin.ventas.recibos.create', [
        'notificacion_ids' => $notificacion_ids,
    ])

    @livewire('admin.clientes.save')
    @livewire('admin.items.create-modal')

</x-admin-layout>

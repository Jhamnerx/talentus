<x-admin-layout ruta="ventas-recibos">

    @livewire('admin.ventas.recibos.create', [
        'periodo_ids' => $periodo_ids,
        'presupuesto_id' => $presupuesto_id ?? null,
    ])

    @livewire('admin.clientes.save')
    @livewire('admin.items.create-modal')

</x-admin-layout>

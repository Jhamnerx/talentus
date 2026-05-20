<x-admin-layout>

    @livewire('admin.facturacion.ventas.emitir', [
        'comprobante_slug' => Request::segment(2),
        'periodo_ids' => $periodo_ids,
        'presupuesto_id' => $presupuesto_id ?? null,
    ])

    @livewire('admin.items.create-modal')
    @livewire('admin.clientes.save')

</x-admin-layout>

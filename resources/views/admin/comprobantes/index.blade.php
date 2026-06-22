<x-admin-layout>

    @livewire('admin.facturacion.ventas.index')

    @livewire('admin.facturacion.ventas.anular-comprobante', [], key('anular-comprobante'))

    @livewire('admin.facturacion.utiles.consulta-cdr', [], key('consulta-comprobante'))
    @livewire('admin.reportes.ventas')
    @livewire('admin.reportes.detalles-items')
    @livewire('admin.shared.pagos-modal')
</x-admin-layout>

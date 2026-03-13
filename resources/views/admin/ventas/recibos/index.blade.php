<x-admin-layout ruta="ventas-recibos">

    <!-- Table -->
    @livewire('admin.ventas.recibos.recibos-index')
    @livewire('admin.reportes.ventas')
    @livewire('admin.ventas.recibos.send')
    @livewire('admin.ventas.recibos.eliminar-recibo')
    @livewire('admin.shared.pagos-modal')
</x-admin-layout>

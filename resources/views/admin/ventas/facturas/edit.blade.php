<x-admin-layout ruta="ventas-facturas">

    @livewire('admin.ventas.facturas.edit', ['factura' => $factura])

    @livewire('admin.clientes.save')

</x-admin-layout>

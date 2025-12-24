<x-admin-layout ruta="ventas-recibos">

    @livewire('admin.ventas.recibos.edit', ['recibo' => $recibo])

    @livewire('admin.clientes.save')
    @livewire('admin.productos.create-modal')

</x-admin-layout>

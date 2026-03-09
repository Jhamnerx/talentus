<x-admin-layout ruta="ventas-presupuestos">

    @livewire('admin.ventas.presupuestos.edit', ['presupuesto' => $presupuesto])

    @livewire('admin.clientes.save')
    @livewire('admin.productos.create-modal')
    @livewire('admin.productos.modal-add-producto')

</x-admin-layout>

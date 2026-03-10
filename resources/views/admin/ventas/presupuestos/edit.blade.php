<x-admin-layout ruta="ventas-presupuestos">

    @livewire('admin.ventas.presupuestos.edit', ['presupuesto' => $presupuesto])

    @livewire('admin.clientes.save')
    @livewire('admin.items.create-modal')
    @livewire('admin.items.modal-add-producto')

</x-admin-layout>

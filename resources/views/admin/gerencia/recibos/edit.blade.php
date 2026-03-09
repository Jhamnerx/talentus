<x-admin-layout ruta="administracion-recibos">

    @livewire('admin.gerencia.recibos.edit', ['recibo' => $recibo])

    @livewire('admin.clientes.save')

</x-admin-layout>

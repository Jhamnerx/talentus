<x-admin-layout>

    <!-- Table -->
    @livewire('admin.clientes.clientes-index')

    @livewire('admin.clientes.import')
    @livewire('admin.clientes.save')
    @livewire('admin.clientes.edit')
    @livewire('admin.clientes.delete')

    <script>
        window.addEventListener('clientes-import', event => {
            iziToast.success({
                position: 'topRight',
                title: 'IMPORTE COMPLETO',
                message: 'se importo los clientes perfectamente',
            });

        })
    </script>

</x-admin-layout>

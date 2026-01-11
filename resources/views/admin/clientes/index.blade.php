<x-admin-layout>

    <!-- Table -->
    @livewire('admin.clientes.clientes-index')

    @livewire('admin.clientes.import', key('import-clientes'))
    @livewire('admin.clientes.save', key('save-clientes'))
    @livewire('admin.clientes.edit', key('edit-clientes'))


    <script>
        window.addEventListener('clientes-import', event => {
            iziToast.success({
                position: 'topRight',
                title: 'IMPORTE COMPLETO',
                message: 'se importo los clientes perfectamente',
            });

        })
    </script>

    @push('modals')
        @livewire('admin.clientes.eliminar-cliente', key('eliminar-cliente'))
    @endpush

</x-admin-layout>

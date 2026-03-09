<x-admin-layout>

    <!-- Table -->
    @livewire('admin.payment-methods.payment-methods-index')

    @livewire('admin.payment-methods.save', key('save-payment-method'))
    @livewire('admin.payment-methods.edit', key('edit-payment-method'))

    <script>
        window.addEventListener('payment-method-saved', event => {
            iziToast.success({
                position: 'topRight',
                title: 'GUARDADO',
                message: 'Método de pago registrado correctamente',
            });
        })

        window.addEventListener('payment-method-updated', event => {
            iziToast.success({
                position: 'topRight',
                title: 'ACTUALIZADO',
                message: 'Método de pago actualizado correctamente',
            });
        })
    </script>

    @push('modals')
        @livewire('admin.payment-methods.eliminar-payment-method', key('eliminar-payment-method'))
    @endpush

</x-admin-layout>

<x-admin-layout>

    <!-- Table -->
    @livewire('admin.payments.payments-index')

    @livewire('admin.payments.save', key('save-payments'))
    @livewire('admin.payments.edit', key('edit-payments'))

    <script>
        window.addEventListener('payment-saved', event => {
            iziToast.success({
                position: 'topRight',
                title: 'GUARDADO',
                message: 'Pago registrado correctamente',
            });
        })

        window.addEventListener('payment-updated', event => {
            iziToast.success({
                position: 'topRight',
                title: 'ACTUALIZADO',
                message: 'Pago actualizado correctamente',
            });
        })
    </script>

    @push('modals')
        @livewire('admin.payments.eliminar-payment', key('eliminar-payment'))
    @endpush

</x-admin-layout>

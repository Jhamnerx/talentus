<x-admin-layout>

    @livewire('admin.portal.accesos-index')

    <script>
        window.addEventListener('toast', event => {
            const detail = event.detail[0] ?? event.detail;
            iziToast[detail.type ?? 'success']({
                position: 'topRight',
                title: (detail.type ?? 'success') === 'success' ? 'Listo' : 'Atención',
                message: detail.message ?? '',
            });
        });
    </script>

</x-admin-layout>

<x-admin-layout>

    @livewire('admin.facturacion.nota.emitir', ['comprobante_slug' => Request::segment(3)])

    @livewire('admin.facturacion.utiles.iframe-modal')

</x-admin-layout>

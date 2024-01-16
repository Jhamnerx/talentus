<x-form.modal.card title="VER COMPROBANTE {{ $serie_correlativo }}" blur wire:model.live="modalFrame">

    <div class="col-span-12 md:col-start-2 md:col-end-5">

        <div class="col-span-12 max-h-min h-screen">
            <iframe src="{{ route('facturacion.ver.pdf', $serie_correlativo) }}" height="100%" width="100%"
                frameborder="0" allowtransparency="true" loading="eager">
            </iframe>
        </div>

    </div>

    <x-slot name="footer">
        <div class="flex justify-between gap-x-4">

            <div class="flex">

                <x-form.button primary label="CERRAR" wire:click="close" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

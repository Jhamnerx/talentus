<x-form.modal.card title="ANULAR COMPROBANTE" wire:model.live="openModal" align="center">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 sm:col-span-4">

            <x-form.input label="Serie:" wire:model.live="serie_ref" id="serie" type="text" readonly />

        </div>
        <div class="col-span-12 sm:col-span-4">

            <x-form.input label="Correlativo:" wire:model.live="correlativo_ref" id="correlativo" type="text"
                readonly />

        </div>
        <div class="col-span-12 sm:col-span-12">

            <x-form.input label="Motivo de Anulación:" wire:model.live="motivo" id="motivo" type="text" />

        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" wire:click.prevent='closeModal' />
                <x-form.button primary label="Anular" wire:click.prevent='anularComprobante' />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

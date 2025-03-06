<x-form.modal.card title="Crear Comprobante" blur wire:model.live="modalInvoice" width="4xl" align="center">

    <div class="grid grid-cols-12 gap-6">

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

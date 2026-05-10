<div>
    <x-form.modal.card title="Crear Lista / Phonebook" blur wire:model.live="showModal" align="center">
        <x-form.input wire:model="name" label="Nombre de la lista" placeholder="Ej: Clientes Lima" />
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="save" spinner="save" primary label="Crear lista" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>

<div>
    <x-form.modal.card title="Eliminar Contacto" blur wire:model.live="showModal" align="center">
        <p class="text-gray-600 dark:text-gray-300">
            ¿Eliminar a <strong>{{ $contactName }}</strong> ({{ $contactNumber }})? Esta acción es irreversible.
        </p>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="delete" spinner="delete" negative label="Eliminar" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>

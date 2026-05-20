<div>
    <x-form.modal.card title="Eliminar Dispositivo" blur wire:model.live="showModal" align="center">
        <p class="text-gray-600 dark:text-gray-300">
            ¿Estás seguro de eliminar el dispositivo <strong>{{ $deviceName }}</strong>? Esta acción no se puede
            deshacer.
        </p>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="delete" spinner="delete" negative label="Sí, eliminar" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>

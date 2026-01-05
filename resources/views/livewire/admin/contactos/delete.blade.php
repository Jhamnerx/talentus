<div>
    @if ($showModal)
        <x-form.modal.card title="Confirmar Eliminación" wire:model="showModal" blur>
            <p class="text-gray-600 dark:text-gray-400">
                ¿Estás seguro de que deseas eliminar este mensaje de contacto? Esta acción no se puede deshacer.
            </p>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-2">
                    <x-form.button flat label="Cancelar" wire:click="closeModal" />
                    <x-form.button negative label="Eliminar" wire:click="confirmarEliminacion" />
                </div>
            </x-slot>
        </x-form.modal.card>
    @endif
</div>

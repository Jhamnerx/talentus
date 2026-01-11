<div>
    <x-form.modal.card title="Eliminar Categoría" wire:model="modalDelete" width="md">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 mb-4">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">¿Eliminar Categoría?</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                ¿Estás seguro de eliminar la categoría <strong>{{ $categoria?->nombre }}</strong>? Esta acción no
                se puede deshacer.
            </p>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-form.button label="Cancelar" wire:click="closeModal" flat />
                <x-form.button label="Eliminar" wire:click="delete" negative spinner="delete" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>

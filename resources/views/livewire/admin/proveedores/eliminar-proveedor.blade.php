<div>
    <x-form.modal.card title="Eliminar Proveedor" wire:model="mostrarModal" width="md">
        <div class="flex gap-4">
            <div class="shrink-0">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/20">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    ¿Estás seguro de eliminar este proveedor?
                </p>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-2">
                <x-form.button flat label="Cancelar" wire:click="cerrarModal" />
                <x-form.button negative label="Sí, Eliminar" wire:click="eliminar" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>

<div>
    <x-form.modal.card title="Eliminar Ticket" wire:model="showModal" blur>
        <div class="space-y-4">
            <div class="flex items-start">
                <div
                    class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full dark:bg-red-900/20">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>

            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    ¿Está seguro de eliminar este ticket?
                </h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    El ticket <span class="font-semibold">{{ $ticketCode }}</span> será eliminado permanentemente.
                    Esta acción no se puede deshacer.
                </p>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-2">
                <x-form.button flat label="Cancelar" wire:click="$set('showModal', false)" />
                <x-form.button negative label="Eliminar" wire:click="delete" spinner="delete" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>

<x-form.modal.card title="ELIMINAR RUBRO" max-width="sm" wire:model.live="openModal">
    <div class="text-center py-4">
        <svg class="w-12 h-12 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <p class="text-gray-700 dark:text-gray-300 font-medium">¿Eliminar el rubro <strong>{{ $rubro?->nombre }}</strong>?</p>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Los clientes con este rubro quedarán sin rubro asignado.</p>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-form.button flat label="Cancelar" wire:click="close" />
            <x-form.button negative label="Eliminar" wire:click="delete" />
        </div>
    </x-slot>
</x-form.modal.card>

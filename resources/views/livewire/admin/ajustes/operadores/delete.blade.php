<x-form.modal.card title="ELIMINAR OPERADOR" max-width="sm" wire:model.live="openModalDelete" align="center">

    <div class="px-6 py-5 text-center">
        <svg class="w-12 h-12 text-rose-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
        </svg>
        <p class="text-gray-700 dark:text-gray-300 text-sm">
            ¿Estás seguro de eliminar el operador
            <span class="font-bold">{{ strtoupper($operador?->name ?? '') }}</span>?
            <br>Esta acción no se puede deshacer.
        </p>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            <x-form.button label="Cancelar" wire:click="$set('openModalDelete', false)" flat />
            <x-form.button label="Eliminar" wire:click="delete" negative spinner="delete" />
        </div>
    </x-slot>

</x-form.modal.card>

<div>
    <x-form.modal.card title="ELIMINAR PLANTILLA" max-width="sm" wire:model.live="openModal" align="center">

        <div class="px-5 py-4 text-center">
            <svg class="w-12 h-12 text-rose-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
            <p class="text-gray-700 dark:text-gray-200 font-medium">¿Estás seguro de eliminar esta plantilla?</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Sector: <strong>{{ $plantilla?->sector?->nombre ?? 'Por defecto' }}</strong>
            </p>
            @if ($plantilla?->archivo_url)
                <p class="text-xs text-gray-400 mt-1">Se eliminará también el archivo adjunto.</p>
            @endif
            <p class="text-sm text-rose-500 mt-2">Esta acción no se puede deshacer.</p>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cancelar" wire:click.prevent="close" />
                <x-form.button negative label="Sí, eliminar" wire:click.prevent="delete" spinner="delete" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>

<x-form.modal.card title="Suspender Vehículo" wire:model.live="modalSuspend" width="md">
    <div class="flex gap-4">
        <!-- Icon -->
        <div class="flex-shrink-0">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-yellow-100 dark:bg-yellow-900/20">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>

        <!-- Content -->
        <div class="flex-1">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                ¿Estás seguro de suspender el vehículo? Se guardará la información requerida para volver a activarlo.
            </p>

            @if ($vehiculo && $vehiculo->dispositivos)
                <div class="mt-4">
                    <x-form.checkbox wire:model.live="remove" label="Remover IMEI del GPS" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        El IMEI actual se guardará en otro campo para permitir usar el dispositivo en otra unidad.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-2">
            <x-form.button flat label="Cancelar" x-on:click="close" />
            <x-form.button warning label="Sí, Suspender" wire:click="suspend" />
        </div>
    </x-slot>
</x-form.modal.card>

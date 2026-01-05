<div>
    @if ($showModal && $contacto)
        <x-form.modal.card title="Detalles del Contacto" wire:model="showModal" blur width="4xl">
            <div class="space-y-4">
                <!-- Información básica -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $contacto->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $contacto->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $contacto->phone ?? 'No proporcionado' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Empresa</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $contacto->company ?? 'No proporcionado' }}</p>
                    </div>
                </div>

                <!-- Mensaje -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mensaje</label>
                    <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">
                            {{ $contacto->message }}</p>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-gray-500 dark:text-gray-400">
                    <div>
                        <span class="font-medium">IP:</span> {{ $contacto->ip_address }}
                    </div>
                    <div>
                        <span class="font-medium">Fecha:</span> {{ $contacto->created_at->format('d/m/Y H:i:s') }}
                    </div>
                    @if ($contacto->leido)
                        <div class="col-span-2">
                            <span class="font-medium">Leído el:</span>
                            {{ $contacto->fecha_leido?->format('d/m/Y H:i:s') }}
                        </div>
                    @endif
                </div>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-2">
                    <x-form.button primary label="Cerrar" wire:click="closeModal" />
                </div>
            </x-slot>
        </x-form.modal.card>
    @endif
</div>

<div>
    <x-form.modal.card title="Sincronizar Contactos de WhatsApp" blur wire:model.live="showModal" align="center">
        <div class="space-y-4">

            {{-- Info box --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Sincronizar desde WhatsApp</h3>
                        <div class="mt-1 text-sm text-blue-700 dark:text-blue-400">
                            <p>Esta función importará todos los contactos individuales guardados en tu WhatsApp.</p>
                            <p class="mt-1">Los contactos se agregarán al grupo "Sincronizados". Puedes reasignarlos
                                después.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- No devices --}}
            @if ($devices->isEmpty())
                <div class="text-center py-6">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No hay dispositivos conectados
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Necesitas tener al menos un dispositivo
                        conectado para sincronizar contactos.</p>
                </div>
            @else
                <x-form.select wire:model="device_body" label="Dispositivo WhatsApp"
                    placeholder="Selecciona el dispositivo">
                    @foreach ($devices as $device)
                        <x-select.option value="{{ $device->body }}" label="{{ $device->body }}" />
                    @endforeach
                </x-form.select>
            @endif

            {{-- Loading --}}
            @if ($importing)
                <div class="text-center py-4">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Sincronizando contactos...</p>
                </div>
            @endif

        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" :disabled="$importing" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="sync" spinner="sync" primary label="Sincronizar Contactos"
                    :disabled="$devices->isEmpty() || $importing" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>

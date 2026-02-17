<x-form.modal.card title="🔗 ASIGNAR LÍNEA A SIM CARD (Primera vez)" width="2xl" blur wire:model.live="modalAsign">

    <!-- Advertencia informativa -->
    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
        <div class="flex gap-3">
            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd" />
            </svg>
            <div class="text-sm text-blue-800 dark:text-blue-200">
                <p class="font-semibold mb-1">Este modal es para asignaciones nuevas</p>
                <p>Solo aparecerán chips y líneas que <strong>NO</strong> tengan asignaciones previas. Si necesitas
                    cambiar una asignación existente, usa las opciones "Cambiar número" o "Cambiar chip".</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Seleccionar SIM Card -->
        <div>
            <x-form.select id="sim_card_id" label="1️⃣ Selecciona el chip (SIM Card)" wire:model.live="sim_card_id"
                placeholder="Buscar por IMEI..." :async-data="route('api.simcards.disponibles')" x-on:clear="$wire.clearSimCardId()"
                option-label="sim_card" option-description="operador" option-value="id">
                <x-slot name="beforeOptions">
                    <p class="px-3 py-2 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800">
                        💡 Solo chips sin línea asignada
                    </p>
                </x-slot>
            </x-form.select>

            @if ($sim_card ?? false)
                <div
                    class="mt-3 p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-200 dark:border-indigo-700">
                    <p class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold mb-1">SIM Card seleccionado:
                    </p>
                    <p class="text-sm font-bold text-indigo-900 dark:text-indigo-100">{{ $sim_card->sim_card }}</p>
                    <p class="text-xs text-indigo-700 dark:text-indigo-300">{{ $sim_card->operador }}</p>
                </div>
            @endif
        </div>

        <!-- Seleccionar Línea -->
        <div>
            <x-form.select id="lineas_id" label="2️⃣ Selecciona la línea (número)" wire:model.live="lineas_id"
                placeholder="Buscar por número..." :async-data="route('api.lineas.disponibles')" x-on:clear="$wire.clearLineaId()"
                option-label="numero" option-description="operador" option-value="id">
                <x-slot name="beforeOptions">
                    <p class="px-3 py-2 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800">
                        💡 Solo líneas sin chip asignado
                    </p>
                </x-slot>
            </x-form.select>

            @if ($linea ?? false)
                <div
                    class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-700">
                    <p class="text-xs text-green-600 dark:text-green-400 font-semibold mb-1">Línea seleccionada:</p>
                    <p class="text-sm font-bold text-green-900 dark:text-green-100">{{ $linea->numero }}</p>
                    <p class="text-xs text-green-700 dark:text-green-300">{{ $linea->operador }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Vista previa de la asignación -->
    @if (($sim_card ?? false) && ($linea ?? false))
        <div
            class="mt-6 p-4 bg-linear-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-lg border border-purple-200 dark:border-purple-700">
            <p class="text-xs text-purple-600 dark:text-purple-400 font-semibold mb-3 uppercase">Vista previa de la
                asignación:</p>
            <div class="flex items-center justify-center gap-4">
                <div class="text-center">
                    <div
                        class="w-16 h-16 mx-auto mb-2 bg-indigo-100 dark:bg-indigo-900/40 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Chip</p>
                    <p class="text-sm font-bold text-indigo-900 dark:text-indigo-100">{{ $sim_card->sim_card }}</p>
                </div>

                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>

                <div class="text-center">
                    <div
                        class="w-16 h-16 mx-auto mb-2 bg-green-100 dark:bg-green-900/40 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Línea</p>
                    <p class="text-sm font-bold text-green-900 dark:text-green-100">{{ $linea->numero }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Motivo (opcional) -->
    <div class="mt-6">
        <x-form.textarea id="motivo" label="3️⃣ Motivo de la asignación (opcional)"
            placeholder="Ej: Nueva compra, reemplazo de chip dañado, etc." wire:model.live="motivo" rows="2" />
    </div>

    <x-slot name="footer">
        <div class="flex justify-between items-center w-full">
            <div class="text-xs text-gray-500 dark:text-gray-400">
                💾 Se guardará en el historial de cambios
            </div>
            <div class="flex gap-x-3">
                <x-form.button flat label="Cancelar" wire:click="closeModal" />
                <x-form.button primary label="🔗 Asignar" wire:click="save" :disabled="!$sim_card_id || !$lineas_id" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

@push('scripts')
@endpush

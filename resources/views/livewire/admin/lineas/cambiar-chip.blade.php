<x-form.modal.card title="💳 CAMBIAR CHIP DE LA LÍNEA" blur wire:model.live="openModal" width="2xl">

    @if ($linea ?? false)
        <!-- Info de la Línea actual -->
        <div
            class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border-2 border-green-200 dark:border-green-700">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold">Línea (Número móvil)</p>
                    <p class="text-lg font-bold text-green-900 dark:text-green-100">{{ $linea->numero }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $linea->operador }}</p>
                </div>
            </div>

            @if ($linea->sim_card)
                <div class="mt-3 pt-3 border-t border-green-200 dark:border-green-700">
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Chip actual:</p>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                        <span
                            class="font-bold text-orange-700 dark:text-orange-400">{{ $linea->sim_card->sim_card }}</span>
                        <span
                            class="text-xs px-2 py-0.5 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 rounded">
                            Será reemplazado
                        </span>
                    </div>
                </div>
            @else
                <div class="mt-3 pt-3 border-t border-green-200 dark:border-green-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 italic">⚠️ Sin chip asignado actualmente</p>
                </div>
            @endif
        </div>

        <!-- Seleccionar nuevo chip -->
        <div class="mb-4">
            <x-form.select label="🆕 Selecciona el nuevo chip (SIM Card)" wire:model.live="nuevo_sim_card_id"
                placeholder="Buscar por IMEI..." :async-data="route('api.simcards.disponibles')" option-label="sim_card" option-description="operador"
                option-value="id" :clearable="true">
                <x-slot name="beforeOptions">
                    <p class="px-3 py-2 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800">
                        💡 Solo se muestran chips disponibles (sin número asignado)
                    </p>
                </x-slot>
            </x-form.select>

            @if ($nuevo_sim_card ?? false)
                <div
                    class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-800 dark:text-blue-200">
                                {{ $nuevo_sim_card->sim_card }} - {{ $nuevo_sim_card->operador }}
                            </p>
                            <p class="text-xs text-blue-600 dark:text-blue-400">Chip disponible para asignar</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Motivo del cambio -->
        <div class="mb-4">
            <x-form.textarea wire:model.live="motivo" label="Motivo del cambio (opcional)"
                placeholder="Ej: Chip dañado, robo, pérdida, cambio de tecnología, etc." rows="2" />
        </div>

        <!-- Resumen visual del cambio -->
        @if ($linea->sim_card && $nuevo_sim_card)
            <div
                class="mb-4 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700">
                <p class="text-xs text-purple-600 dark:text-purple-400 mb-2 font-semibold uppercase">Vista previa del
                    cambio:</p>
                <div class="flex items-center justify-center gap-4">
                    <div class="text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Chip actual</p>
                        <p class="text-lg font-bold text-orange-600 dark:text-orange-400">
                            {{ $linea->sim_card->sim_card }}</p>
                    </div>
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    <div class="text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Nuevo chip</p>
                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $nuevo_sim_card->sim_card }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Advertencia sobre el chip anterior -->
        @if ($linea->sim_card)
            <div
                class="mb-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-700">
                <div class="flex gap-2">
                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 flex-shrink-0" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="text-xs text-yellow-800 dark:text-yellow-200">
                        <p class="font-semibold mb-1">El chip anterior quedará liberado:</p>
                        <p>El SIM {{ $linea->sim_card->sim_card }} quedará sin número asignado y podrá ser reutilizado.
                        </p>
                    </div>
                </div>
            </div>
        @endif

    @endif

    <x-slot name="footer">
        <div class="flex justify-between items-center w-full">
            <div class="text-xs text-gray-500 dark:text-gray-400">
                💾 Se guardará en el historial de cambios
            </div>
            <div class="flex gap-x-3">
                <x-form.button flat label="Cancelar" wire:click="closeModal" />
                <x-form.button primary label="💳 Cambiar chip" wire:click="cambiarChip" :disabled="!$nuevo_sim_card_id" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

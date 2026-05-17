<x-form.modal.card title="🔄 CAMBIAR NÚMERO DEL SIM CARD" blur wire:model.live="openModal" width="2xl">

    @if ($sim_card ?? false)
        <!-- Info del SIM Card actual -->
        <div
            class="mb-6 p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border-2 border-indigo-200 dark:border-indigo-700">
            <div class="flex items-center gap-3">
                <div class="shrink-0">
                    <svg class="w-10 h-10 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold">SIM Card (Chip físico)
                    </p>
                    <p class="text-lg font-bold text-indigo-900 dark:text-indigo-100">{{ $sim_card->sim_card }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $sim_card->operador?->name ?? '—' }}</p>
                </div>
            </div>

            @if ($sim_card->linea)
                <div class="mt-3 pt-3 border-t border-indigo-200 dark:border-indigo-700">
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Número actual:</p>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span
                            class="font-bold text-orange-700 dark:text-orange-400">{{ $sim_card->linea->numero }}</span>
                        <span
                            class="text-xs px-2 py-0.5 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 rounded">
                            Será reemplazado
                        </span>
                    </div>
                </div>
            @else
                <div class="mt-3 pt-3 border-t border-indigo-200 dark:border-indigo-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 italic">⚠️ Sin número asignado actualmente</p>
                </div>
            @endif
        </div>

        <!-- Seleccionar nueva línea -->
        <div class="mb-4">
            <x-form.select label="🆕 Selecciona el nuevo número" wire:model.live="nueva_linea_id"
                placeholder="Buscar por número..." :async-data="route('api.lineas.disponibles')" option-label="numero" option-description="operador"
                option-value="id" :clearable="true">
                <x-slot name="beforeOptions">
                    <p class="px-3 py-2 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800">
                        💡 Solo se muestran líneas disponibles (sin asignar)
                    </p>
                </x-slot>
            </x-form.select>

            @if ($nueva_linea ?? false)
                <div
                    class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-700">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-green-800 dark:text-green-200">
                                {{ $nueva_linea->numero }} - {{ $nueva_linea->operador?->name ?? '—' }}
                            </p>
                            <p class="text-xs text-green-600 dark:text-green-400">Línea disponible para asignar</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Motivo del cambio -->
        <div class="mb-4">
            <x-form.textarea wire:model.live="motivo" label="Motivo del cambio (opcional)"
                placeholder="Ej: Cambio por duplicado de chip, nueva numeración, etc." rows="2" />
        </div>

        <!-- Resumen visual del cambio -->
        @if ($sim_card->linea && $nueva_linea)
            <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
                <p class="text-xs text-blue-600 dark:text-blue-400 mb-2 font-semibold uppercase">Vista previa del
                    cambio:</p>
                <div class="flex items-center justify-center gap-4">
                    <div class="text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Número actual</p>
                        <p class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $sim_card->linea->numero }}
                        </p>
                    </div>
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    <div class="text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Nuevo número</p>
                        <p class="text-lg font-bold text-green-600 dark:text-green-400">{{ $nueva_linea->numero }}</p>
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
                <x-form.button primary label="🔄 Cambiar número" wire:click="cambiarNumero" :disabled="!$nueva_linea_id" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

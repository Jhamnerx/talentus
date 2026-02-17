<x-form.modal.card title="🗑️ ELIMINAR ASIGNACIÓN DE NÚMERO" wire:model.live="openUnAsign" align="center" max-width="2xl">

    <div class="space-y-4">
        <!-- Advertencia principal -->
        <div
            class="p-4 bg-linear-to-r from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/20 rounded-lg border border-rose-300 dark:border-rose-700">
            <div class="flex items-start gap-3">
                <div class="shrink-0">
                    <svg class="w-6 h-6 text-rose-600 dark:text-rose-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-rose-900 dark:text-rose-100 mb-1">
                        ⚠️ Acción Irreversible
                    </h4>
                    <p class="text-sm text-rose-700 dark:text-rose-300">
                        Estás a punto de eliminar la asignación del número. El SIM card físico quedará sin línea
                        asociada.
                    </p>
                </div>
            </div>
        </div>

        @if ($sim_card ?? null)
            <!-- Información del SIM card -->
            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold mb-1">SIM Card
                            </p>
                            <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $sim_card->sim_card }}
                            </p>
                        </div>
                        @if ($sim_card->linea)
                            <div class="text-right">
                                <p class="text-xs text-gray-600 dark:text-gray-400 uppercase font-semibold mb-1">Línea
                                    actual</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-gray-100">📱
                                    {{ $sim_card->linea->numero }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $sim_card->linea->operador }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                            <span class="font-semibold">Consecuencia:</span> El número se desasignará y quedará
                            registrado en el historial de cambios.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-3">
            <x-form.button flat label="Cancelar" wire:click="closeModal" />
            <x-form.button negative label="Sí, Eliminar" wire:click="unAsign" icon="trash" />
        </div>
    </x-slot>
</x-form.modal.card>

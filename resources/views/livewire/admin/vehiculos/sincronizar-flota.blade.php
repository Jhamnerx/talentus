<div
    x-data="{
        errors: [],
        async iniciarLoop() {
            await $wire.iniciar();
            let done = false;
            while (!done) {
                const r = await $wire.procesarSiguiente();
                if (r.error) this.errors.push(r.error);
                done = r.terminado;
                if (!done) {
                    await new Promise(res => setTimeout(res, 800));
                }
            }
        }
    }"
    x-on:reset-sync-errors.window="errors = []"
>

    <x-form.modal.card
        title="Sincronizar Flota con GPSWox"
        max-width="2xl"
        blur
        wire:model.live="modalOpen"
        align="center"
    >
        <div class="space-y-5">

            {{-- Estado: Listo para iniciar --}}
            @if (! $corriendo && ! $terminado)
                <div class="flex flex-col items-center gap-3 py-4">
                    <svg class="w-16 h-16 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-300 text-center">
                        Se consultará la plataforma GPSWox placa por placa para actualizar
                        <strong>IMEI, SIM y ID</strong> de cada vehículo.
                    </p>

                    <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                        <input type="checkbox" wire:model.live="soloNoSincronizados"
                            class="rounded border-gray-300 text-violet-500 focus:ring-violet-400">
                        Solo verificar los que no están en GPSWox / nunca sincronizados
                    </label>

                    @if ($total > 0)
                        <p class="text-sm text-gray-400 dark:text-gray-500">
                            Total de vehículos a procesar: <strong class="text-gray-700 dark:text-gray-200">{{ $total }}</strong>
                        </p>
                        <p class="text-xs text-amber-500 dark:text-amber-400">
                            Este proceso puede tardar varios minutos. No cierre esta ventana.
                        </p>
                    @else
                        <p class="text-sm text-emerald-600 dark:text-emerald-400">
                            No hay vehículos pendientes de sincronizar.
                        </p>
                    @endif
                </div>
            @endif

            {{-- Barra de progreso --}}
            @if ($corriendo || $terminado)
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-200">
                            @if ($corriendo)
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-violet-500 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Procesando...
                                </span>
                            @else
                                ✅ Sincronización completada
                            @endif
                        </span>
                        <span class="text-gray-500 dark:text-gray-400 font-mono">
                            {{ $procesados }} / {{ $total }}
                        </span>
                    </div>

                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                        <div
                            class="h-3 rounded-full transition-all duration-300 {{ $terminado ? 'bg-emerald-500' : 'bg-violet-500' }}"
                            style="width: {{ $total > 0 ? round($procesados / $total * 100) : 0 }}%">
                        </div>
                    </div>

                    <p class="text-xs text-gray-400 dark:text-gray-500 text-right">
                        {{ $total > 0 ? round($procesados / $total * 100) : 0 }}%
                    </p>
                </div>
            @endif

            {{-- Placas no encontradas (Alpine-managed — sin pasar por Livewire state) --}}
            <div x-show="errors.length > 0" x-cloak class="border border-amber-200 dark:border-amber-800 rounded-lg overflow-hidden">
                <div class="bg-amber-50 dark:bg-amber-900/20 px-4 py-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-semibold text-amber-700 dark:text-amber-400">
                        <span x-text="errors.length + (errors.length === 1 ? ' placa no encontrada' : ' placas no encontradas') + ' en GPSWox'"></span>
                    </span>
                </div>
                <div class="max-h-48 overflow-y-auto divide-y divide-amber-100 dark:divide-amber-900/30">
                    <template x-for="(item, index) in errors" :key="index">
                        <div class="px-4 py-2 flex items-start gap-3 bg-white dark:bg-gray-800/50">
                            <span class="font-mono font-bold text-sm text-gray-800 dark:text-gray-100 shrink-0 w-24" x-text="item.placa"></span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 truncate" x-text="item.message"></span>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Resumen final --}}
            @if ($terminado)
                <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg px-4 py-3 text-sm">
                    <p class="font-medium text-emerald-700 dark:text-emerald-400">
                        Proceso finalizado:
                        <strong>{{ $procesados - $noEncontradosCount }}</strong> actualizados,
                        <strong>{{ $noEncontradosCount }}</strong> no encontrados en plataforma.
                    </p>
                </div>
            @endif

        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                @if (! $corriendo && ! $terminado)
                    <x-form.button flat label="Cancelar" wire:click="cerrar" />
                    <x-form.button
                        primary
                        icon="arrow-path"
                        label="Iniciar Sincronización"
                        :disabled="$total === 0"
                        @click="iniciarLoop()"
                    />
                @elseif ($corriendo)
                    <x-form.button negative label="Detener" wire:click="cancelar" />
                @else
                    <x-form.button primary label="Cerrar" wire:click="cerrar" />
                @endif
            </div>
        </x-slot>
    </x-form.modal.card>

</div>
